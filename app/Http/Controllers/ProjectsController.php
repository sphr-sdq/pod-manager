<?php

namespace App\Http\Controllers;

use App\Models\Pods;
use App\Models\Projects;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request , $slug)
    {
        $project = $request->user()->projects()->where('slug' , $slug)->first();

        return Inertia::render('Dashboard/User/Project' , [
            'bannerTitle' => $project->name,
            'bannerBody' => 'در این قسمت می‌توانید پروژه‌ی خود را مدیریت کنید و برای دیپلوی برنالمه‌ها اقدام کنید',
            'pods' => Pods::all()->select(['name' , 'slug' , 'image_path'])

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
    public function store(Request $request)
    {
        //
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
