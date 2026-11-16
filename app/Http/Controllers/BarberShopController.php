<?php

namespace App\Http\Controllers;

use App\Models\rc;
use Illuminate\Http\Request;
use App\Models\BarberShop;

class BarberShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required'],
            'phone' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'zip' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        BarberShop::create($validation);
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(rc $rc)
    {
        //
        return view('auth.show',['rc'=>$rc]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rc $rc)
    {
        return view('auth.edit',['rc'=>$rc]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rc $rc)
    {

        $validation = $request->validate([
            'name' => ['required'],
            'phone' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'zip' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $rc->update($validation);
        return redirect()->route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rc $rc)
    {
        $rc->delete();
        return redirect()->route('index');
    }
}
