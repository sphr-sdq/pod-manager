<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\namespaces;
use App\Models\Pods;
use App\Models\Project_Resources;
use App\Models\Projects;
use http\Client\Curl\User;
use HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $slug)
    {
        $project = $request->user()->projects()->where('slug', $slug)->first();



        if (!$project) {
            return Inertia::render('Dashboard/User/Project', [
                'bannerTitle' => Namespaces::where('slug', $slug)->first()?->name,
                'bannerBody' => 'در این قسمت می‌توانید پروژه‌ی خود را مدیریت کنید و برای دیپلوی برنامه‌ها اقدام کنید',
                'pods' => Pods::all()->select(['name', 'slug', 'image_path']),
                'slug' => Namespaces::where('slug', $slug)->first()?->slug,
                'projects' => [],
                "ingress" => collect(),
            ]);
        }

        $actualProject = Projects::where("namespace_id", $project->id)->with('namespace')->with('pod')->first();


        $project_resource = collect();
        if ($actualProject) {
            $project_resource = Project_Resources::where("project_id", $actualProject->id)->get();
        }

        return Inertia::render('Dashboard/User/Project', [
            'bannerTitle' => Namespaces::where('slug', $slug)->first()?->name,
            'bannerBody' => 'در این قسمت می‌توانید پروژه‌ی خود را مدیریت کنید و برای دیپلوی برنامه‌ها اقدام کنید',
            'pods' => Pods::all()->select(['name', 'slug', 'image_path']),
            'slug' => Namespaces::where('slug'  , $slug)->first()?->slug,
            'projects' => $actualProject ?? [],
            "ingress" => $project_resource->isEmpty() ? collect() : $project_resource ,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $slug)
    {
        try {
            $res = $request->request->all();

            // Check for app_id and user_namespace in the request.
            if (!isset($res['app_id']) || !isset($res['user_namespace'])) {
                throw new HttpException(400, 'Missing app_id or user_namespace parameters.');
            }


            // Retrieve the namespace and the pod model, or return null if it does not exist.
            $namespace = Namespaces::where("slug", "=", $res["user_namespace"])->first();
            if(!$namespace)  {
                throw new HttpException(404, 'Namespace with that slug was not found.');
            }
            $pod = Pods::where("slug", "=", $res["app_id"])->first();
            if(!$pod) {
                throw new HttpException(404, 'Pod with that slug was not found.');
            }
            DB::beginTransaction();
            Projects::create([
                "user_id" => $request->user()->id,
                "namespace_id" => $namespace->id,
                "pod_id" => $pod->id,
                "parameters" => json_encode($res)
            ]);
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(env('GO_APP_URL', 'http://go-app:8080').'/deploy', $res);

            if (!$response->successful()) {
                throw new HttpException(502, 'Failed to create Kubernetes namespace: ' . $response->body());
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating project: ', ['exception' => $e]);
            return Inertia::render('Dashboard/User/Project', [
                'errors' =>  [$e->getMessage()],
            ], $e->getCode() ?: 500);
        }
        return redirect()->back();
    }
    public function store_domain(Request $request)
    {

        $request->validate([
            "user_params.domain" => "required|regex:/^(https?:\/\/)?([\w\d\-]+\.)+[a-z]{2,}(:\d+)?(\/[^\s]*)?$/i"
        ], [
            "required" => "این فیلد ضروری است",
            "regex" => "فرمت آدرس قابل قبول نیست"
        ]);


        $data =
            [
                "app_id" => $request->request->all()["app_id"],
                "user_params" => $request->request->all()["user_params"],
                "user_namespace" => $request->request->all()["user_namespace"],
            ]
        ;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://go-app:8080/ingress', $data);

        if (!$response->successful()) {
            throw new \Exception('Failed to create domain: ' . $response->body());
        }

        Project_Resources::create([
            "project_id" => $request->request->all()["id"],
            "resource" => json_encode($data)
        ]);
    }

    public function delete_domain(Request $request , $slug ,$id)
    {

        $ingress = Project_Resources::where('id' , '=' ,$id)->first();



        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://go-app:8080/delete_ingress', json_decode($ingress->resource));

        if (!$response->successful()) {
            throw new \Exception('Failed to create domain: ' . $response->body());
        }

        Project_Resources::where('project_id' , '=' ,$ingress->project_id)->get()->each(function ($resource) {
            $resource->delete();
        });

        return redirect()->back()->with('success', 'Project resources deleted.');


    }

    public function update_resource(Request $request)
    {

        $data = [
            "app_id" => $request->request->all()["app_id"],
            "user_params" => $request->request->all()["user_params"],
            "user_namespace"=>$request->request->all()["user_namespace"]
        ];
        $project = Projects::where("id" , $request->request->get("project_id"))->first();
        $project->parameters = json_encode($data);
        $project->save();
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://go-app:8080/update', $data);

        if (!$response->successful()) {
            throw new \Exception('Failed to update resources: ' . $response->body());
        }
    }

    public function certificate($slug){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get("http://go-app:8080/certificates", [
            'namespace' => $slug,
        ]);
        if ($response->successful()) {
            return response()->json($response->json(), 200);
        } else {
            return response()->json(['error' => $response->body()], $response->status());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $projects)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projects $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $projects)
    {
        //
    }
}
