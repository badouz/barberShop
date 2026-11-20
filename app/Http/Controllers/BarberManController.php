<?php

namespace App\Http\Controllers;

use App\Models\BarberMan;
use App\Models\BarberShop;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarberManController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = BarberMan::with('barberShop');

        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            $query->whereIn('barbershop_id', $shopIds);
        }

        $barberMen = $query->paginate(10);

        return view('barbermen.index', compact('barberMen'));
    }

    public function create()
    {
        $user = Auth::user();
        $allBarberShops = ($user && $user->isAdmin())
            ? BarberShop::all()
            : $user->barberShops;

        return view('barbermen.create', compact('allBarberShops'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            if (!in_array((int)$validated['barbershop_id'], $shopIds)) {
                abort(403, 'Accès interdit. Vous ne pouvez assigner un barbier qu’à votre propre salon.');
            }
        }

        BarberMan::create($validated);

        return redirect()->route('barbermen.index')
            ->with('success', 'Barber Man created successfully');
    }

    public function show(BarberMan $barberman)
    {
        $this->authorizeBarber($barberman);

        return view('barbermen.show', ['barberMan' => $barberman]);
    }

    public function edit(BarberMan $barberman)
    {
        $this->authorizeBarber($barberman);

        $user = Auth::user();
        $allBarberShops = ($user && $user->isAdmin())
            ? BarberShop::all()
            : $user->barberShops;

        return view('barbermen.edit', [
            'barberMan'      => $barberman,
            'allBarberShops' => $allBarberShops,
        ]);
    }

    public function update(Request $request, BarberMan $barberman)
    {
        $this->authorizeBarber($barberman);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'barbershop_id' => 'required|exists:barbershops,id',
        ]);

        $user = Auth::user();
        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            if (!in_array((int)$validated['barbershop_id'], $shopIds)) {
                abort(403, 'Accès interdit. Vous ne pouvez pas déplacer un barbier vers un autre salon.');
            }
        }

        $barberman->update($validated);

        return redirect()->route('barbermen.index')
            ->with('success', 'Barber Man updated successfully');
    }

    public function destroy(BarberMan $barberman)
    {
        $this->authorizeBarber($barberman);

        try {
            $barberman->delete();
        } catch (QueryException $e) {
            return redirect()->route('barbermen.index')
                ->with('error', 'This barber is reserved and cannot be deleted');
        }

        return redirect()->route('barbermen.index')
            ->with('success', 'Barber Man deleted successfully');
    }

    private function authorizeBarber(BarberMan $barberman): void
    {
        $user = Auth::user();
        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            if (!in_array((int)$barberman->barbershop_id, $shopIds)) {
                abort(403, 'Accès interdit. Ce barbier n’appartient pas à votre salon.');
            }
        }
    }
}
