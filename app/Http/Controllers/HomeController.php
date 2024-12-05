<?php

namespace App\Http\Controllers;

use App\Models\Pods;
use App\Models\Tags;
use Illuminate\Http\Request;
use Inertia\Inertia;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Home' , [
            "pods" => Pods::with('tags')->get()
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
    public function show(Pods $pods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pods $pods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pods $pods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pods $pods)
    {
        //
    }
}
