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
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public const APPOINTMENT_TIMES = [
        '09:00', '10:00', '11:00', '12:00', '14:00', '15:00',
        '16:00', '17:00', '18:00', '19:00', '20:00',
    ];

    /**
     * Helper to get public URL for a barbershop image.
     */
    public function shopImage(BarberShop $shop): string
    {
        $primary = $shop->barberShopImages->firstWhere('is_primary', true)
            ?? $shop->barberShopImages->first();

        if ($primary && $primary->path) {
            return Str::startsWith($primary->path, ['http://', 'https://'])
                ? $primary->path
                : Storage::url($primary->path);
        }

        return 'https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=1200&q=85&auto=format&fit=crop';
    }

    /**
     * Helper to get public URL for a service image.
     */
    public function serviceImage(Service $service): string
    {
        $primary = $service->primaryImage ?? $service->serviceImages->first();

        if ($primary && $primary->path) {
            return Str::startsWith($primary->path, ['http://', 'https://'])
                ? $primary->path
                : Storage::url($primary->path);
        }

        return 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=600&q=80&auto=format&fit=crop';
    }

    /**
     * 01 — Home page: loads salons from DB with real Purple data.
     */
    public function home(Request $request)
    {
        try {
            $shops = BarberShop::with([
                'services.serviceImages',
                'services.primaryImage',
                'barberMen',
                'barberShopImages',
            ])->get();
        } catch (\Throwable $e) {
            $shops = collect();
        }

        $shopsList = $shops->map(function (BarberShop $shop, int $index) {
            $minPrice = $shop->services->min('price');

            // Collect unique category tags based on actual service names
            $serviceCategories = [];
            foreach ($shop->services as $svc) {
                $nameLower = strtolower($svc->name);
                if (str_contains($nameLower, 'cut') || str_contains($nameLower, 'hair') || str_contains($nameLower, 'fade')) {
                    $serviceCategories[] = 'haircut';
                }
                if (str_contains($nameLower, 'beard') || str_contains($nameLower, 'barbe')) {
                    $serviceCategories[] = 'beard';
                }
                if (str_contains($nameLower, 'style') || str_contains($nameLower, 'color') || str_contains($nameLower, 'brush')) {
                    $serviceCategories[] = 'styling';
                }
            }
            if (empty($serviceCategories)) {
                $serviceCategories = ['haircut'];
            }

            return [
                'id'          => $shop->id,
                'name'        => $shop->name,
                'rating'      => 4.9,
                'address'     => $shop->address ?: 'Adresse non renseignée',
                'city'        => $shop->city ?: 'Ville',
                'location'    => trim(($shop->address ?: '') . ' · ' . ($shop->city ?: '')),
                'price_from'  => $minPrice !== null ? $minPrice : null,
                'image'       => $this->shopImage($shop),
                'services_cnt'=> $shop->services->count(),
                'barbers_cnt' => $shop->barberMen->count(),
                'categories'  => array_values(array_unique($serviceCategories)),
                'is_featured' => $index === 0,
            ];
        });

        $featuredShop = $shopsList->firstWhere('is_featured', true) ?? $shopsList->first();
        $compactShops = $shopsList->reject(fn ($s) => $featuredShop && $s['id'] === $featuredShop['id']);

        return view('welcome', compact('shopsList', 'featuredShop', 'compactShops'));
    }

    /**
     * 02 — Select Services: Displays services for a selected shop (or shop chooser).
     */
    public function services(Request $request)
    {
        $allShops = BarberShop::with(['services.serviceImages', 'services.primaryImage', 'barberShopImages'])->get();

        $shopId = $request->query('shop_id', session('reservation_shop_id'));

        $currentShop = null;
        if ($shopId) {
            $currentShop = BarberShop::with([
                'services.serviceImages',
                'services.primaryImage',
                'barberMen',
                'barberShopImages',
            ])->find($shopId);
        }

        // If no shop chosen yet, default to first shop if available
        if (!$currentShop && $allShops->isNotEmpty()) {
            $currentShop = $allShops->first();
        }

        $selectedServiceIds = session('reservation_service_ids', []);
        $selectedServiceIds = is_array($selectedServiceIds) ? $selectedServiceIds : [];

        return view('services', [
            'allShops'           => $allShops,
            'currentShop'        => $currentShop,
            'selectedServiceIds' => $selectedServiceIds,
            'controller'         => $this,
        ]);
    }

    /**
     * Store selected service IDs in session.
     */
    public function selectServices(Request $request)
    {
        $validated = $request->validate([
            'service_ids'   => ['required', 'array', 'min:1'],
            'service_ids.*' => ['required', 'integer', 'distinct', 'exists:services,id'],
            'shop_id'       => ['nullable', 'integer', 'exists:barbershops,id'],
        ]);

        $services = Service::whereIn('id', $validated['service_ids'])->get();

        if ($services->count() !== count($validated['service_ids'])) {
            throw ValidationException::withMessages([
                'service_ids' => 'Une ou plusieurs prestations ne sont plus disponibles.',
            ]);
        }

        if ($services->pluck('barbershop_id')->unique()->count() > 1) {
            throw ValidationException::withMessages([
                'service_ids' => 'Veuillez choisir des prestations appartenant au même salon.',
            ]);
        }

        $shopId = $services->first()->barbershop_id;

        $request->session()->put('reservation_service_ids', $services->pluck('id')->all());
        $request->session()->put('reservation_shop_id', $shopId);

        return redirect()->route('reservation.index');
    }

    /**
     * 03 — Reservation form: Choose barber, date, time slot, guest name & phone.
     */
    public function index(Request $request)
    {
        $serviceIds = $request->session()->get('reservation_service_ids', []);
        $serviceIds = is_array($serviceIds) ? $serviceIds : [];

        if (empty($serviceIds)) {
            return redirect()->route('reservation.services')
                ->with('warning', 'Veuillez sélectionner au moins une prestation avant de continuer.');
        }

        $selectedServices = Service::with([
            'serviceImages' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('id'),
        ])
            ->whereIn('id', $serviceIds)
            ->get();

        if ($selectedServices->isEmpty()) {
            $request->session()->forget(['reservation_service_ids', 'reservation_shop_id']);
            return redirect()->route('reservation.services');
        }

        $shopId = $selectedServices->first()->barbershop_id;
        $shop = BarberShop::with(['barberMen', 'barberShopImages'])->find($shopId);

        if (!$shop) {
            $request->session()->forget(['reservation_service_ids', 'reservation_shop_id']);
            return redirect()->route('reservation.services');
        }

        $totalPrice = $selectedServices->sum('price');
        $totalDuration = $selectedServices->sum('duration');

        return view('reservation', [
            'shop'             => $shop,
            'selectedServices' => $selectedServices,
            'totalPrice'       => $totalPrice,
            'totalDuration'    => $totalDuration,
            'barbers'          => $shop->barberMen,
            'appointmentTimes' => self::APPOINTMENT_TIMES,
            'minimumDate'      => now()->toDateString(),
            'controller'       => $this,
        ]);
    }

    /**
     * 04 — Store guest reservation in DB.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:120'],
            'phone'         => ['required', 'string', 'max:30'],
            'barberman_id'  => ['required', 'integer', 'exists:barbermans,id'],
            'date'          => ['required', 'date', 'after_or_equal:today'],
            'time'          => ['required', 'in:' . implode(',', self::APPOINTMENT_TIMES)],
        ]);

        $serviceIds = $request->session()->get('reservation_service_ids', []);
        $serviceIds = is_array($serviceIds) ? $serviceIds : [];

        if (empty($serviceIds)) {
            throw ValidationException::withMessages([
                'services' => 'Veuillez choisir au moins une prestation avant de valider votre réservation.',
            ]);
        }

        $services = Service::whereIn('id', $serviceIds)->get();
        if ($services->isEmpty()) {
            throw ValidationException::withMessages([
                'services' => 'Les prestations sélectionnées ne sont plus disponibles.',
            ]);
        }

        $shopId = $services->first()->barbershop_id;
        $barber = BarberMan::findOrFail($validated['barberman_id']);

        if ((int) $barber->barbershop_id !== (int) $shopId) {
            throw ValidationException::withMessages([
                'barberman_id' => 'Le barbier sélectionné n’appartient pas à ce salon.',
            ]);
        }

        $totalPrice = $services->sum('price');
        $totalDuration = max((int) $services->sum('duration'), 1);

        try {
            $reservation = DB::transaction(function () use ($validated, $barber, $services, $totalPrice, $totalDuration) {
                BarberMan::whereKey($barber->id)->lockForUpdate()->firstOrFail();

                $requestedStart = $this->timeInMinutes($validated['time']);
                $requestedEnd   = $requestedStart + $totalDuration;

                $appointments = Reservation::with('services')
                    ->where('barbermans_id', $barber->id)
                    ->whereDate('dateReservation', $validated['date'])
                    ->whereNotNull('time')
                    ->where('status', '!=', 'cancelled')
                    ->get();

                foreach ($appointments as $appointment) {
                    $existingStart = $this->timeInMinutes($appointment->time);
                    $existingDuration = max((int) $appointment->services->sum('duration'), 1);
                    $existingEnd = $existingStart + $existingDuration;

                    if ($requestedStart < $existingEnd && $existingStart < $requestedEnd) {
                        throw ValidationException::withMessages([
                            'time' => 'Ce créneau horaire chevauche un rendez-vous déjà réservé. Veuillez en choisir un autre.',
                        ]);
                    }
                }

                $reservation = Reservation::create([
                    'user_id'         => auth()->id(), // null if guest
                    'dateReservation' => $validated['date'],
                    'time'            => $validated['time'],
                    'price'           => $totalPrice,
                    'barbermans_id'   => $barber->id,
                    'name'            => $validated['name'],
                    'phone'           => $validated['phone'],
                    'status'          => 'confirmed',
                ]);

                $reservation->services()->attach($services->pluck('id'));

                return $reservation;
            });
        } catch (QueryException $exception) {
            if (str_contains($exception->getMessage(), 'reservations_barbermans_id_datereservation_time_unique')
                || str_contains($exception->getMessage(), 'UNIQUE constraint failed')) {
                throw ValidationException::withMessages([
                    'time' => 'Ce créneau vient d’être réservé à l’instant. Veuillez en sélectionner un autre.',
                ]);
            }
            throw $exception;
        }

        $request->session()->forget(['reservation_service_ids', 'reservation_shop_id']);

        return redirect()->route('reservation.confirmation', $reservation->id);
    }

    /**
     * 05 — Confirmation view with CHAIR layout.
     */
    public function confirmation(Reservation $reservation)
    {
        $reservation->load(['barberMan.barberShop.barberShopImages', 'services']);

        $shop = $reservation->barberMan?->barberShop;
        $image = $shop ? $this->shopImage($shop) : 'https://images.unsplash.com/photo-1585747860715-2ba37e788b70?w=1200&q=85&auto=format&fit=crop';

        return view('reservation-confirmation', compact('reservation', 'shop', 'image'));
    }

    private function timeInMinutes(string $time): int
    {
        [$hours, $minutes] = array_map('intval', explode(':', $time));
        return ($hours * 60) + $minutes;
    }
}
