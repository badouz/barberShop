<?php

namespace App\Http\Controllers;

use App\Models\BarberMan;
use App\Models\BarberShop;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    private const APPOINTMENT_TIMES = [
        '09:00', '10:00', '11:00', '12:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00',
    ];

    private const FALLBACK_IMAGES = [
        'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=900&q=85',
        'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=900&q=85',
        'https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=900&q=85',
        'https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=900&q=85',
        'https://images.unsplash.com/photo-1512690459411-b9245aed614b?w=900&q=85',
        'https://images.unsplash.com/photo-1517832606299-7ae9b720a186?w=900&q=85',
        'https://images.unsplash.com/photo-1605497788044-5a32c7078486?w=900&q=85',
    ];

    public function services()
    {
        $servicesList = Service::with([
            'barberShop',
            'serviceImages' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('id'),
        ])
            ->orderBy('name')
            ->get()
            ->map(function (Service $service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name ?: 'Prestation',
                    'price' => $service->price,
                    'duration' => $service->duration,
                    'shop_id' => $service->barbershop_id,
                    'shop_name' => $service->barberShop?->name ?: 'Salon',
                    'description' => $service->description ?: 'Prestation professionnelle disponible dans ce salon.',
                    'image' => $this->serviceImage($service),
                ];
            });

        $selectedServiceIds = session('reservation_service_ids', []);

        return view('services', [
            'servicesList' => $servicesList,
            'selectedServiceIds' => is_array($selectedServiceIds) ? $selectedServiceIds : [],
        ]);
    }

    public function selectServices(Request $request)
    {
        $validated = $request->validate([
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['required', 'integer', 'distinct', 'exists:services,id'],
        ]);

        $services = Service::whereIn('id', $validated['service_ids'])->get();

        if ($services->count() !== count($validated['service_ids'])) {
            throw ValidationException::withMessages([
                'service_ids' => 'Une ou plusieurs prestations ne sont plus disponibles.',
            ]);
        }

        if ($services->pluck('barbershop_id')->unique()->count() > 1) {
            throw ValidationException::withMessages([
                'service_ids' => 'Choisissez des prestations dans un seul salon par réservation.',
            ]);
        }

        if ($services->contains(fn (Service $service) => $service->price === null)) {
            throw ValidationException::withMessages([
                'service_ids' => 'Une prestation choisie n’a pas encore de prix défini.',
            ]);
        }

        $services = $services->sortBy(fn (Service $service) => array_search(
            $service->id,
            $validated['service_ids']
        ))->values();

        $request->session()->put('reservation_service_ids', $services->pluck('id')->all());
        $request->session()->put('reservation_shop_id', $services->first()->barbershop_id);

        return redirect()->route('reservation.index');
    }

    public function index(Request $request)
    {
        $serviceIds = $request->session()->get('reservation_service_ids', []);
        $serviceIds = is_array($serviceIds) ? $serviceIds : [];
        $selectedServices = Service::with([
            'serviceImages' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('id'),
        ])
            ->whereIn('id', $serviceIds)
            ->get()
            ->sortBy(fn (Service $service) => array_search($service->id, $serviceIds))
            ->values();

        if ($selectedServices->count() !== count($serviceIds)) {
            $request->session()->forget(['reservation_service_ids', 'reservation_shop_id']);
            $selectedServices = collect();
        }

        $shop = $selectedServices->isNotEmpty()
            ? BarberShop::with('barberMen')->find($selectedServices->first()->barbershop_id)
            : null;

        if ($selectedServices->isNotEmpty() && ! $shop) {
            $request->session()->forget(['reservation_service_ids', 'reservation_shop_id']);
            $selectedServices = collect();
        }

        $selectedServiceCards = $selectedServices->values()->map(function (Service $service) {
            return ['service' => $service, 'image' => $this->serviceImage($service)];
        });

        return view('reservation', [
            'selectedServices' => $selectedServiceCards,
            'shop' => $shop,
            'appointmentTimes' => self::APPOINTMENT_TIMES,
            'minimumDate' => now()->toDateString(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'barberman_id' => ['required', 'integer', 'exists:barbermans,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', Rule::in(self::APPOINTMENT_TIMES)],
        ]);

        if ($validated['date'] === now()->toDateString() && $validated['time'] <= now()->format('H:i')) {
            throw ValidationException::withMessages([
                'time' => 'Veuillez choisir un horaire qui n’est pas encore passé.',
            ]);
        }

        $serviceIds = $request->session()->get('reservation_service_ids', []);
        $serviceIds = is_array($serviceIds) ? $serviceIds : [];
        $services = Service::whereIn('id', $serviceIds)->get();

        if ($services->isEmpty() || $services->count() !== count($serviceIds)) {
            throw ValidationException::withMessages([
                'service_ids' => 'Choisissez au moins une prestation encore disponible.',
            ]);
        }

        $shopId = $services->first()->barbershop_id;

        if ($services->contains(fn (Service $service) => (int) $service->barbershop_id !== (int) $shopId)) {
            throw ValidationException::withMessages([
                'service_ids' => 'Les prestations doivent appartenir au même salon.',
            ]);
        }

        $barber = BarberMan::findOrFail($validated['barberman_id']);

        if ((int) $barber->barbershop_id !== (int) $shopId) {
            throw ValidationException::withMessages([
                'barberman_id' => 'Le barbier choisi ne travaille pas dans le salon sélectionné.',
            ]);
        }

        if ($services->contains(fn (Service $service) => $service->price === null)) {
            throw ValidationException::withMessages([
                'service_ids' => 'Une prestation choisie n’a pas de prix défini.',
            ]);
        }

        $totalPrice = $services->sum('price');
        $totalDuration = max((int) $services->sum('duration'), 1);
        $serviceNames = $services->pluck('name')->all();

        try {
            DB::transaction(function () use ($validated, $barber, $services, $totalPrice, $totalDuration) {
                BarberMan::whereKey($barber->id)->lockForUpdate()->firstOrFail();

                $requestedStart = $this->timeInMinutes($validated['time']);
                $requestedEnd = $requestedStart + $totalDuration;
                $appointments = Reservation::with('services')
                    ->where('barbermans_id', $barber->id)
                    ->whereDate('dateReservation', $validated['date'])
                    ->whereNotNull('time')
                    ->get();

                foreach ($appointments as $appointment) {
                    $existingStart = $this->timeInMinutes($appointment->time);
                    $existingDuration = max((int) $appointment->services->sum('duration'), 1);
                    $existingEnd = $existingStart + $existingDuration;

                    if ($requestedStart < $existingEnd && $existingStart < $requestedEnd) {
                        throw ValidationException::withMessages([
                            'time' => 'Ce créneau chevauche un rendez-vous déjà réservé. Veuillez en choisir un autre.',
                        ]);
                    }
                }

                $reservation = Reservation::create([
                    'dateReservation' => $validated['date'],
                    'time' => $validated['time'],
                    'price' => $totalPrice,
                    'barbermans_id' => $barber->id,
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                ]);

                $reservation->services()->attach($services->modelKeys());
            });
        } catch (QueryException $exception) {
            $message = $exception->getMessage();
            $isDuplicateAppointment = str_contains($message, 'reservations_barbermans_id_datereservation_time_unique')
                || str_contains($message, 'UNIQUE constraint failed: reservations.barbermans_id, reservations.dateReservation, reservations.time');

            if (! $isDuplicateAppointment) {
                throw $exception;
            }

            throw ValidationException::withMessages([
                'time' => 'Ce créneau vient d’être réservé. Veuillez en choisir un autre.',
            ]);
        }

        $request->session()->forget(['reservation_service_ids', 'reservation_shop_id']);

        return redirect()
            ->route('reservation.index')
            ->with('success', 'Votre réservation a été envoyée avec succès.')
            ->with('confirmed_reservation', [
                'services' => $serviceNames,
                'date' => $validated['date'],
                'time' => $validated['time'],
                'price' => $totalPrice,
                'barber' => $barber->name,
            ]);
    }

    private function timeInMinutes(string $time): int
    {
        [$hours, $minutes] = array_map('intval', explode(':', $time));

        return ($hours * 60) + $minutes;
    }

    private function serviceImage(Service $service): string
    {
        $imagePath = $service->serviceImages->first()?->path;

        if ($imagePath) {
            return Str::startsWith($imagePath, ['http://', 'https://'])
                ? $imagePath
                : Storage::url($imagePath);
        }

        $imageIndex = ((int) $service->id - 1) % count(self::FALLBACK_IMAGES);

        return self::FALLBACK_IMAGES[$imageIndex];
    }
}
