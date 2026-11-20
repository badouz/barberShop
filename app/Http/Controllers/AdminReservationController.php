<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of reservations for Purple Admin.
     * Isolated by role:
     * - ADMIN sees all reservations across all shops.
     * - BARBERSHOP only sees reservations belonging to their own shop(s).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $baseQuery = Reservation::query();

        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            $baseQuery->whereHas('barberMan', function ($q) use ($shopIds) {
                $q->whereIn('barbershop_id', $shopIds);
            });
        }

        $stats = [
            'total'     => (clone $baseQuery)->count(),
            'confirmed' => (clone $baseQuery)->where('status', 'confirmed')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
            'revenue'   => (clone $baseQuery)->whereIn('status', ['confirmed', 'completed'])->sum('price'),
            'today'     => (clone $baseQuery)->whereDate('dateReservation', now()->toDateString())->count(),
        ];

        $query = (clone $baseQuery)->with(['barberMan.barberShop', 'services']);

        if ($request->filled('status') && in_array($request->status, ['confirmed', 'completed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        $reservations = $query->latest('id')->paginate(15)->withQueryString();

        return view('reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Cancel or update reservation status.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
        $this->authorizeReservation($reservation);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:confirmed,completed,cancelled'],
        ]);

        $reservation->update(['status' => $validated['status']]);

        return back()->with('success', 'Statut de la réservation mis à jour.');
    }

    /**
     * Delete a reservation.
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorizeReservation($reservation);

        $reservation->services()->detach();
        $reservation->delete();

        return back()->with('success', 'Réservation supprimée avec succès.');
    }

    /**
     * Verify that the authenticated barbershop owns this reservation.
     */
    private function authorizeReservation(Reservation $reservation): void
    {
        $user = Auth::user();
        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            $reservationShopId = $reservation->barberMan?->barbershop_id;

            if (!$reservationShopId || !in_array($reservationShopId, $shopIds)) {
                abort(403, 'Accès interdit. Cette réservation n’appartient pas à votre salon.');
            }
        }
    }
}
