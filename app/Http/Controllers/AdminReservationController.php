<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of reservations for Purple Admin.
     */
    public function index()
    {
        $reservations = Reservation::with(['barberMan.barberShop', 'services'])
            ->latest('id')
            ->paginate(15);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Cancel or update reservation status.
     */
    public function updateStatus(Request $request, Reservation $reservation)
    {
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
        $reservation->services()->detach();
        $reservation->delete();

        return back()->with('success', 'Réservation supprimée avec succès.');
    }
}
