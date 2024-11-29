<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request)
    {
        if($request->user()->hasRole('admin')){
            return Inertia::render('Dashboard/Admin/Profile' ,
                 [
                    "bannerTitle" => "تنظیمات",
                     "bannerBody" => "در این قسمت می‌توانید مشخصات کاربری خود را تغییر دهید",
                     "name" => $request->user()->name,
                     "family" => $request->user()->family,
                     "phoneNumber" => $request->user()->phoneNumber
                ]);
        }else{
            return Inertia::render('Dashboard/User/Profile' ,
                [
                    "bannerTitle" => "تنظیمات",
                    "bannerBody" => "در این قسمت می‌توانید مشخصات کاربری خود را تغییر دهید",
                    "name" => $request->user()->name,
                    "family" => $request->user()->family,
                    "phoneNumber" => $request->user()->phoneNumber
                ]);
//            abort(403);
        }

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
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //
        $verified = $request->validate([
            'name' => 'required',
            'family' => 'required'
        ]
        ,
        [
            'required' => "پر کردن این فیلد اجباری است"
        ]);
        $request->user()->update([
            'name' => $verified['name'],
            'family' => $verified['family']
        ]);

        return redirect()->back()->with('success', 'Name/Family updated successfully!');
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
