<?php

namespace App\Http\Controllers;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    // ─── Shared barber-shop image helper ─────────────────────────────────────

    private const SHOP_FALLBACK_IMAGES = [
        'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=900&q=85',
        'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=900&q=85',
        'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=900&q=85',
        'https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=900&q=85',
        'https://images.unsplash.com/photo-1512690459411-b9245aed614b?w=900&q=85',
        'https://images.unsplash.com/photo-1517832606299-7ae9b720a186?w=900&q=85',
        'https://images.unsplash.com/photo-1605497788044-5a32c7078486?w=900&q=85',
    ];

    private const BARBER_AVATAR_IMAGES = [
        'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80',
        'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80',
        'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&q=80',
        'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&q=80',
        'https://images.unsplash.com/photo-1527980965255-d3b416303d12?w=200&q=80',
        'https://images.unsplash.com/photo-1543610892-0b1f7e6d8ac1?w=200&q=80',
    ];

    private const APPOINTMENT_TIMES = [
        '09:00', '10:00', '11:00', '12:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00',
    ];

    private function shopImage(BarberShop $shop): string
    {
        $primary = $shop->barberShopImages->firstWhere('is_primary', true)
            ?? $shop->barberShopImages->first();

        if ($primary) {
            $path = $primary->path;
            return Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : Storage::url($path);
        }

        $idx = ((int) $shop->id - 1) % count(self::SHOP_FALLBACK_IMAGES);
        return self::SHOP_FALLBACK_IMAGES[$idx];
    }

    private function barberAvatar(BarberMan $barber): string
    {
        $idx = ((int) $barber->id - 1) % count(self::BARBER_AVATAR_IMAGES);
        return self::BARBER_AVATAR_IMAGES[$idx];
    }

    private function timeInMinutes(string $time): int
    {
        [$h, $m] = array_map('intval', explode(':', $time));
        return ($h * 60) + $m;
    }

    // ─── 01  Home ─────────────────────────────────────────────────────────────

    public function home(Request $request)
    {
        $search   = $request->input('search', '');
        $category = $request->input('category', 'haircut');

        $shopsQuery = BarberShop::with(['barberShopImages', 'services', 'barberMen']);

        if ($search) {
            $shopsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhereHas('services', fn ($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        $shops = $shopsQuery->get()->map(function (BarberShop $shop) {
            return (object) [
                'id'      => $shop->id,
                'name'    => $shop->name,
                'city'    => $shop->city,
                'address' => $shop->address,
                'image'   => $this->shopImage($shop),
                'rating'  => 4.9,
                'distance'=> '0.8 km away',
                'minPrice'=> $shop->services->min('price') ?? 30,
            ];
        });

        return view('client.home', compact('shops', 'search', 'category'));
    }

    // ─── 02  Shop detail ─────────────────────────────────────────────────────

    public function shop(BarberShop $shop)
    {
        $shop->load(['barberShopImages', 'barberMen', 'services']);

        $barbers = $shop->barberMen->map(function (BarberMan $b) {
            return (object) [
                'id'     => $b->id,
                'name'   => $b->name,
                'avatar' => $this->barberAvatar($b),
            ];
        });

        return view('client.shop', [
            'shop'    => $shop,
            'image'   => $this->shopImage($shop),
            'barbers' => $barbers,
            'services'=> $shop->services,
        ]);
    }

    // ─── 03  Reservation form ────────────────────────────────────────────────

    public function reserve(BarberShop $shop)
    {
        $shop->load(['barberShopImages', 'barberMen', 'services']);

        $barbers = $shop->barberMen->map(function (BarberMan $b) {
            return (object) [
                'id'     => $b->id,
                'name'   => $b->name,
                'avatar' => $this->barberAvatar($b),
            ];
        });

        return view('client.reserve', [
            'shop'    => $shop,
            'image'   => $this->shopImage($shop),
            'barbers' => $barbers,
            'services'=> $shop->services,
            'times'   => self::APPOINTMENT_TIMES,
            'user'    => Auth::user(),
        ]);
    }

    // ─── 03  Store reservation ───────────────────────────────────────────────

    public function storeReservation(Request $request, BarberShop $shop)
    {
        $validated = $request->validate([
            'barberman_id' => ['required', 'integer', 'exists:barbermans,id'],
            'service_id'   => ['required', 'integer', 'exists:services,id'],
            'date'         => ['required', 'date', 'after_or_equal:today'],
            'time'         => ['required', 'in:' . implode(',', self::APPOINTMENT_TIMES)],
            'name'         => ['required', 'string', 'max:120'],
            'phone'        => ['required', 'string', 'max:30'],
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $barber  = BarberMan::findOrFail($validated['barberman_id']);

        // Guard: service and barber must belong to this shop
        abort_if((int) $service->barbershop_id !== (int) $shop->id, 403, 'Invalid service for this shop.');
        abort_if((int) $barber->barbershop_id  !== (int) $shop->id, 403, 'Invalid barber for this shop.');

        $duration = max((int) $service->duration, 1);

        try {
            $reservation = DB::transaction(function () use ($validated, $barber, $service, $duration) {
                BarberMan::whereKey($barber->id)->lockForUpdate()->firstOrFail();

                $reqStart = $this->timeInMinutes($validated['time']);
                $reqEnd   = $reqStart + $duration;

                $appointments = Reservation::with('services')
                    ->where('barbermans_id', $barber->id)
                    ->whereDate('dateReservation', $validated['date'])
                    ->whereNotNull('time')
                    ->get();

                foreach ($appointments as $appt) {
                    $exStart = $this->timeInMinutes($appt->time);
                    $exDur   = max((int) $appt->services->sum('duration'), 1);
                    $exEnd   = $exStart + $exDur;

                    if ($reqStart < $exEnd && $exStart < $reqEnd) {
                        throw ValidationException::withMessages([
                            'time' => 'This time slot overlaps with an existing appointment. Please choose another.',
                        ]);
                    }
                }

                $reservation = Reservation::create([
                    'user_id'        => Auth::id(),
                    'dateReservation'=> $validated['date'],
                    'time'           => $validated['time'],
                    'price'          => $service->price,
                    'barbermans_id'  => $barber->id,
                    'name'           => $validated['name'],
                    'phone'          => $validated['phone'],
                    'status'         => 'confirmed',
                ]);

                $reservation->services()->attach($service->id);

                return $reservation;
            });
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'reservations_barbermans_id_datereservation_time_unique')) {
                throw ValidationException::withMessages([
                    'time' => 'This slot was just taken. Please pick another.',
                ]);
            }
            throw $e;
        }

        return redirect()->route('client.booking-success', $reservation);
    }

    // ─── 04  Booking success ─────────────────────────────────────────────────

    public function bookingSuccess(Reservation $reservation)
    {
        abort_if($reservation->user_id !== Auth::id(), 403);
        $reservation->load(['barberMan.barberShop.barberShopImages', 'services']);

        $shop  = $reservation->barberMan?->barberShop;
        $image = $shop ? $this->shopImage($shop) : self::SHOP_FALLBACK_IMAGES[0];

        return view('client.booking-success', compact('reservation', 'shop', 'image'));
    }

    // ─── 05  My bookings ─────────────────────────────────────────────────────

    public function myBookings(Request $request)
    {
        $tab = $request->input('tab', 'upcoming');
        $user = Auth::user();

        $reservations = Reservation::with(['barberMan.barberShop.barberShopImages', 'services'])
            ->where('user_id', $user->id)
            ->orderByDesc('dateReservation')
            ->get();

        $upcoming = $reservations->filter(fn ($r) =>
            $r->dateReservation >= now()->toDateString() && $r->status !== 'cancelled'
        )->values();

        $past = $reservations->filter(fn ($r) =>
            $r->dateReservation < now()->toDateString() || $r->status === 'cancelled'
        )->values();

        return view('client.bookings', compact('upcoming', 'past', 'tab'));
    }

    // ─── 06  Reservation detail ──────────────────────────────────────────────

    public function reservationDetails(Reservation $reservation)
    {
        abort_if($reservation->user_id !== Auth::id(), 403);
        $reservation->load(['barberMan.barberShop.barberShopImages', 'services']);

        $shop  = $reservation->barberMan?->barberShop;
        $image = $shop ? $this->shopImage($shop) : self::SHOP_FALLBACK_IMAGES[0];

        $appointmentAt = null;
        if ($reservation->dateReservation && $reservation->time) {
            $appointmentAt = \Carbon\Carbon::parse(
                $reservation->dateReservation . ' ' . $reservation->time
            )->toIso8601String();
        }

        return view('client.reservation-detail', compact('reservation', 'shop', 'image', 'appointmentAt'));
    }

    // ─── Cancel ──────────────────────────────────────────────────────────────

    public function cancelReservation(Request $request, Reservation $reservation)
    {
        abort_if($reservation->user_id !== Auth::id(), 403);
        $reservation->update(['status' => 'cancelled']);

        return redirect()->route('client.bookings')
            ->with('success', 'Reservation cancelled.');
    }

    // ─── Reschedule ──────────────────────────────────────────────────────────

    public function reschedule(Request $request, Reservation $reservation)
    {
        abort_if($reservation->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'in:' . implode(',', self::APPOINTMENT_TIMES)],
        ]);

        $barber   = $reservation->barberMan;
        $duration = max((int) $reservation->services->sum('duration'), 1);
        $reqStart = $this->timeInMinutes($validated['time']);
        $reqEnd   = $reqStart + $duration;

        $conflicts = Reservation::with('services')
            ->where('barbermans_id', $barber->id)
            ->where('id', '!=', $reservation->id)
            ->whereDate('dateReservation', $validated['date'])
            ->whereNotNull('time')
            ->get();

        foreach ($conflicts as $appt) {
            $exStart = $this->timeInMinutes($appt->time);
            $exDur   = max((int) $appt->services->sum('duration'), 1);
            $exEnd   = $exStart + $exDur;

            if ($reqStart < $exEnd && $exStart < $reqEnd) {
                return back()->withErrors(['time' => 'This slot overlaps an existing appointment.']);
            }
        }

        $reservation->update([
            'dateReservation' => $validated['date'],
            'time'            => $validated['time'],
            'status'          => 'confirmed',
        ]);

        return redirect()->route('client.booking-detail', $reservation)
            ->with('success', 'Appointment rescheduled.');
    }

    // ─── 07  Settings ────────────────────────────────────────────────────────

    public function settings()
    {
        return view('client.settings', ['user' => Auth::user()]);
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180', 'unique:users,email,' . $user->id],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated.');
    }
}
