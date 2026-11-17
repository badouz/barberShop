<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\BarberShop;
use Illuminate\Support\Facades\Schema;

class BarberShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barbershops=BarberShop::all();
        return view('barbershop.index',['barbershops'=>$barbershops]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barbershop.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'latitude' => 'required',
            'Longitude' => 'required',
        ]);
        $data['user_id'] = auth()->id();
        BarberShop::create($data);
        return redirect()->route('barbershop.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BarberShop $barbershop)
    {
        return view('barbershop.show',['barbershop'=>$barbershop]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarberShop $barbershop)
    {
        return view('barbershop.edit',['barbershop'=>$barbershop]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarberShop $barbershop)
    {

        $data = $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
            'zip' => 'required',
            'latitude' => 'required',
            'Longitude' => 'required',
        ]);
        $barbershop->update($data);
        return redirect()->route('barbershop.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarberShop $barbershop)
    {
        $barbershop->delete();
        return redirect()->route('barbershop.index');
    }
}
