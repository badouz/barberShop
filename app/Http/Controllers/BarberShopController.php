<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarberShop;
use Illuminate\Support\Facades\Auth;

class BarberShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            $barbershops = BarberShop::latest()->paginate(10);
        } else {
            $barbershops = $user->barberShops()->latest()->paginate(10);
        }
        
        return view('barbershop.index', compact('barbershops'));
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
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'Longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $data['user_id'] = Auth::id();
        BarberShop::create($data);
        return redirect()->route('barbershop.index')->with('success', 'Barbershop créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BarberShop $barbershop)
    {
        $this->authorizeShop($barbershop);

        return view('barbershop.show', ['barbershop' => $barbershop]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarberShop $barbershop)
    {
        $this->authorizeShop($barbershop);

        return view('barbershop.edit', ['barbershop' => $barbershop]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarberShop $barbershop)
    {
        $this->authorizeShop($barbershop);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'Longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $barbershop->update($data);
        return redirect()->route('barbershop.index')->with('success', 'Barbershop mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarberShop $barbershop)
    {
        $this->authorizeShop($barbershop);

        $barbershop->delete();
        return redirect()->route('barbershop.index')->with('success', 'Barbershop supprimé avec succès!');
    }

    /**
     * Authorize that the authenticated barbershop owns this shop.
     */
    private function authorizeShop(BarberShop $barbershop): void
    {
        $user = Auth::user();
        if ($user && $user->isBarberShop() && (int)$barbershop->user_id !== (int)$user->id) {
            abort(403, 'Accès interdit. Ce salon ne vous appartient pas.');
        }
    }
}
