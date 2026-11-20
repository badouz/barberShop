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
        if (Auth::user()->isAdmin()) {
            $barberMen = BarberMan::with('barberShop')->paginate(10);
            
        } elseif (Auth::user()->isBarberShop()) {
            $shopIds = Auth::user()->barberShops()->pluck('id');
            $barberMen = BarberMan::with('barberShop')
                ->whereIn('barbershop_id', $shopIds)
                ->paginate(10);
        } else {
            abort(403);
        }

        return view('barbermen.index', compact('barberMen'));
    }

    public function create()
    {
        if (Auth::user()->isAdmin()) {
            $allBarberShops = BarberShop::all();
        } elseif (Auth::user()->isBarberShop()) {
            $allBarberShops = Auth::user()->barberShops;
        } else {
            abort(403);
        }

        return view('barbermen.create', compact('allBarberShops'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isBarberShop()) {
            abort(403);
        }
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        if (Auth::user()->isBarberShop()) {
            $shop = BarberShop::find($validated['barbershop_id']);
            if ($shop->user_id !== Auth::id()) {
                abort(403);
            }
        }

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
        if (Auth::user()->isAdmin()) {
            $allBarberShops = BarberShop::all();
        } elseif (Auth::user()->isBarberShop()) {
            if ($barberman->barberShop->user_id !== Auth::id()) {
                abort(403);
            }
            $allBarberShops = Auth::user()->barberShops;
        } else {
            abort(403);
        }

        return view('barbermen.edit', [
            'barberMan'      => $barberman,
            'allBarberShops' => $allBarberShops,
        ]);
    }

    public function update(Request $request, BarberMan $barberman)
    {
        if (Auth::user()->isBarberShop() && $barberman->barberShop->user_id !== Auth::id()) {
            abort(403);
        }
        if (!Auth::user()->isAdmin() && !Auth::user()->isBarberShop()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        if (Auth::user()->isBarberShop()) {
            $shop = BarberShop::find($validated['barbershop_id']);
            if ($shop->user_id !== Auth::id()) {
                abort(403);
            }
        }

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