<?php

namespace App\Http\Controllers;

use App\Models\BarberMan;
use App\Models\BarberShop;
use Illuminate\Http\Request;

class BarberManController extends Controller
{
    public function index(){
        $barberMen = BarberMan::paginate(10);
        return view("barbermen.index", compact('barberMen'));
    }

    public function create(){
        $allBarberShops = BarberShop::all();
        return view("barbermen.create", compact('allBarberShops'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        BarberMan::create($validated);
        return redirect()->route('barbermen.index')->with('success', 'Barber Man created successfully');
    }

    public function show(BarberMan $barberMan)
    {
        return view('barbermen.show', compact('barberMan'));
    }

    public function edit(BarberMan $barberMan)
    {
        $allBarberShops = BarberShop::all();
        return view('barbermen.edit', compact('barberMan', 'allBarberShops'));
    }

    public function update(Request $request, BarberMan $barberMan)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        $barberMan->update($validated);
        return redirect()->route('barbermen.index')->with('success', 'Barber Man updated successfully');
    }

    public function destroy(BarberMan $barberMan)
    {
        if ($barberMan->reservations()->exists()) {
            return redirect()->route('barbermen.index')
                ->with('error', 'This barber has reservations and cannot be deleted.');
        }

        $barberMan->delete();
        return redirect()->route('barbermen.index')->with('success', 'Barber Man deleted successfully');
    }
}