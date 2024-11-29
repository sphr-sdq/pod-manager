<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Container\Attributes\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use function Symfony\Component\Translation\t;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //

        Gate::authorize('create', Tags::class);

        return Inertia::render('Dashboard/Admin/Tag' , [
            'tags' => Tags::all()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //
        Gate::authorize('create', Tags::class);

        $validated = $request->validate([
            'tag' => 'required'
        ] ,
        [ 'required' => 'فیلد تگ اجباری است.']
        );

        $tag = new Tags;
        $tag->name = $validated['tag'];
        $tag->save();

        return redirect()->back()->with('success', 'Tag Saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tags $tags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tags $tags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('update' ,Tags::where('id' ,'=' , $id)->first() );

        $validated =  $request->validate([
            'newValue' => 'required'
        ],
        [
            'required' => 'مقدار این فیلد اجباری است'
        ]);

        $tag = Tags::where('id' ,'=' , $id)->first();
        $tag->name = $validated['newValue'];
        $tag->save();

        return redirect()->back()->with('success', 'Tag Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        Gate::authorize('delete' ,Tags::where('id' ,'=' , $id)->first() );
        Tags::where('id' ,'=' , $id)->first()->delete();
        return redirect()->back()->with('success', 'Tag Deleted successfully!');
    }
}
