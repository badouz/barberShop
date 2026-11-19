<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allUsers = Schema::hasTable('auth') ? User::query()->get() : collect();

        return view('auth.index', ['auth' => $allUsers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.sign');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'name'=> $request->name,
            'phone'=> $request->phone,
            'city'=> $request->city,
            'address'=> $request->address,
            'zip'=> $request->zip,
            'email'=> $request->email,
            'password'=> $request->password,
        ]);

        return redirect()->route('auth.index');
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
