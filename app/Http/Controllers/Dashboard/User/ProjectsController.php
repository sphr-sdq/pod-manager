<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\namespaces;
use App\Models\Pods;
use App\Models\Project_Resources;
use App\Models\Projects;
use http\Client\Curl\User;
use Illuminate\Http\Request;
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
        $res = $request->request->all();
        ds(json_encode($request->request->all()));

        Projects::create([
            "user_id" => $request->user()->id,
            "namespace_id" => namespaces::where("slug", "=", $request->request->all()["user_namespace"])->first()->id,
            "pod_id" => Pods::where("slug", "=", $request->request->all()["app_id"])->first()->id,
            "parameters" => json_encode($request->request->all())
        ]);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://go-app:8080/deploy', $res);

        if (!$response->successful()) {
            throw new \Exception('Failed to create Kubernetes namespace: ' . $response->body());
        }
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
