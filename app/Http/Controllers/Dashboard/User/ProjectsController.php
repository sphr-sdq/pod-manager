<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use App\Models\namespaces;
use App\Models\Pods;
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

        ds($request->user()->project()->get());
        return Inertia::render('Dashboard/User/Project', [
            'bannerTitle' => $project->name,
            'bannerBody' => 'در این قسمت می‌توانید پروژه‌ی خود را مدیریت کنید و برای دیپلوی برنالمه‌ها اقدام کنید',
            'pods' => Pods::all()->select(['name', 'slug', 'image_path']),
            'slug' => $project->slug,
            'projects' => $request->user()->project()->get()

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

        // Send POST request with the raw array (Laravel auto-converts it to JSON)

        ds($res);
        Projects::create([
            "user_id" => $request->user()->id,
            "namespace_id" => namespaces::where("slug", "=", $request->request->all()["user_namespace"])->first()->id,
            "pod_id" => Pods::where("slug", "=", $request->request->all()["app_id"])->first()->id,
            "parameters" => json_encode($request->request->all())
        ]);
//        $response = Http::withHeaders([
//            'Content-Type' => 'application/json',
//        ])->post('http://localhost:8080/deploy', $res);
//
//        if (!$response->successful()) {
//            throw new \Exception('Failed to create Kubernetes namespace: ' . $response->body());
//        }
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
