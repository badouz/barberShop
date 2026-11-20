<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Models\BarberMan;
use App\Models\BarberShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberManController extends Controller
{
    public function index()
    {
        
        $barberMen = BarberMan::with('barberShop')->paginate(10);

        return view('barbermen.index', compact('barberMen'));
    }

    public function create()
    {
        $allBarberShops = BarberShop::all();
        return view('barbermen.create', compact('allBarberShops'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        BarberMan::create($validated);

        return redirect()->route('barbermen.index')
            ->with('success', 'Barber Man created successfully');
    }

    public function show(BarberMan $barberman)
    {
        return view('barbermen.show', ['barberMan' => $barberman]);
    }

    public function edit(BarberMan $barberman)
    {
        $allBarberShops = BarberShop::all();

        return view('barbermen.edit', [
            'barberMan'      => $barberman,
            'allBarberShops' => $allBarberShops,
        ]);
    }

    public function update(Request $request, BarberMan $barberman)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        $barberman->update($validated);

        return redirect()->route('barbermen.index')
            ->with('success', 'Barber Man updated successfully');
    }

    public function destroy(BarberMan $barberman)
{
    try {
        $barberman->delete();
    } catch (QueryException $e) {
        return redirect()->route('barbermen.index')
            ->with('error', 'This barber is reserved and cannot be deleted');
    }

    return redirect()->route('barbermen.index')
        ->with('success', 'Barber Man deleted successfully');
}
}