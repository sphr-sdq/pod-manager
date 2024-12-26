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
        return Inertia::render('Home' , [
            "pods" => Pods::with('tags')->get(),
            "tags" => Tags::all()
        ]);
    }

    public function index_pods()
    {
        return Inertia::render('Pods' , [
                "pods" => Pods::with('tags')->get(),
            ]);
    }

    public function single_pod($slug)
    {
        $pod = Pods::where('slug' ,'=',$slug)->first();
        return Inertia::render('SinglePod' , [
            "pod" => $pod->description
        ]);
    }

}
