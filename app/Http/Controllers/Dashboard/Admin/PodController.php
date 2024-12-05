<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pods;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->user()->hasRole('admin')){
            return Inertia::render('Dashboard/Admin/Pod' ,
                [
                    "bannerTitle" => "اضافه کردن برنامه جدید",
                    "bannerBody" => "در اینجا می‌توانید پروژه‌ی جدید تعریف کنید",
                    "tags" => Tags::all()->select(['name' , 'slug'])
                ]);
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'template' => 'required',
            'parameters' => 'required',
            'tags' => 'array'
        ]);

     
        $uniqueFileName = Str::uuid() . '.' . $request->file('image')->extension();
        $path = $request->file('image')->storeAs('uploads', $uniqueFileName, 'public');
        $pod = Pods::create([
            "name" => $validated['title'],
            "slug" => Str::slug($validated['title']),
            "image_path" => $path,
            "user_id" => $request->user()->id,
            'description' => $validated['description'],
            'template' => $validated['template'],
            'parameters' => $validated['parameters'],
        ]);

        foreach ($request['tags'] as $tag) {
            $tagRecord = Tags::where('slug', $tag)->first();
            $pod->tags()->attach($tagRecord->id);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
