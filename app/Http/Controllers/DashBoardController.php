<?php

namespace App\Http\Controllers;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashBoardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $baseQuery = Reservation::query();

        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            $baseQuery->whereHas('barberMan', function ($q) use ($shopIds) {
                $q->whereIn('barbershop_id', $shopIds);
            });
            $barbersCount = BarberMan::whereIn('barbershop_id', $shopIds)->count();
            $shopsCount = count($shopIds);
            $primaryShop = $user->barberShops->first();
        } else {
            $barbersCount = BarberMan::count();
            $shopsCount = BarberShop::count();
            $primaryShop = null;
        }

        $stats = [
            'total'        => (clone $baseQuery)->count(),
            'confirmed'    => (clone $baseQuery)->where('status', 'confirmed')->count(),
            'completed'    => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled'    => (clone $baseQuery)->where('status', 'cancelled')->count(),
            'revenue'      => (clone $baseQuery)->whereIn('status', ['confirmed', 'completed'])->sum('price'),
            'today'        => (clone $baseQuery)->whereDate('dateReservation', now()->toDateString())->count(),
            'barbersCount' => $barbersCount,
            'shopsCount'   => $shopsCount,
        ];

        $recentReservations = (clone $baseQuery)
            ->with(['barberMan.barberShop', 'services'])
            ->latest('id')
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'recentReservations', 'primaryShop'));
    }
}
