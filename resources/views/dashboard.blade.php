@extends("layout.primary")

@section("title")
Dashboard - {{ auth()->user()->isBarberShop() ? ($primaryShop?->name ?? 'Mon Salon') : 'BarberShop Platform' }}
@endsection

@section("content")
@php
    $isShop = auth()->user()->isBarberShop();
@endphp

<!-- Bannière d'accueil -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white border-0 shadow-sm" style="border-radius: 12px; position: relative; overflow: hidden;">
            <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute position-absolute" style="top: 0; right: 0; height: 100%; opacity: 0.25; pointer-events: none;" alt="circle-bg" />
            <div class="card-body p-4 position-relative">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <span class="badge bg-white text-primary fw-bold text-uppercase mb-2 px-3 py-1">
                            <i class="mdi mdi-account-circle me-1"></i> {{ $isShop ? 'Espace Propriétaire de Salon' : 'Super Administrateur' }}
                        </span>
                        <h2 class="fw-bold mb-1 text-white">
                            Bienvenue, {{ auth()->user()->name }} !
                        </h2>
                        <p class="mb-0 text-white-50">
                            {{ $isShop ? ('Performances et réservations de votre salon : ' . ($primaryShop?->name ?? 'Mon Salon')) : 'Vue globale sur toutes les statistiques et les salons du réseau.' }}
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-end">
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-light text-primary fw-bold px-4 py-2 shadow-sm">
                            <i class="mdi mdi-calendar-check me-1"></i> Gérer les Réservations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3 Cartes Statistiques Principales -->
<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Chiffre d'Affaires <i class="mdi mdi-cash-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-4 fw-bold">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} DH</h2>
                <h6 class="card-text text-white-50 small mb-0"><i class="mdi mdi-check-circle me-1"></i> Réservations confirmées & terminées</h6>
            </div>
        </div>
    </div>

    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-primary card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Réservations <i class="mdi mdi-calendar-clock mdi-24px float-end"></i></h4>
                <h2 class="mb-4 fw-bold">{{ $stats['total'] ?? 0 }}</h2>
                <h6 class="card-text text-white-50 small mb-0"><i class="mdi mdi-calendar-today me-1"></i> Aujourd'hui : {{ $stats['today'] ?? 0 }} RDV</h6>
            </div>
        </div>
    </div>

    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">{{ $isShop ? 'Barbiers de l\'équipe' : 'Salons Actifs' }} <i class="mdi {{ $isShop ? 'mdi-account-tie' : 'mdi-store' }} mdi-24px float-end"></i></h4>
                <h2 class="mb-4 fw-bold">{{ $isShop ? ($stats['barbersCount'] ?? 0) : ($stats['shopsCount'] ?? 0) }}</h2>
                <h6 class="card-text text-white-50 small mb-0">
                    <i class="mdi mdi-check-decagram me-1"></i> {{ $isShop ? 'Coiffeurs enregistrés' : 'Salons partenaires' }}
                </h6>
            </div>
        </div>
    </div>
</div>

<!-- Ligne avec Tableau des Dernières Réservations + Répartition -->
<div class="row">
    <!-- Dernières Réservations -->
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="card-title mb-1 fw-bold text-dark">Dernières Réservations</h4>
                        <p class="text-muted small mb-0">Rendez-vous récents pris par vos clients</p>
                    </div>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout <i class="mdi mdi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Barbier</th>
                                <th>Date & Heure</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReservations as $r)
                                @php
                                    $badge = match($r->status) {
                                        'confirmed' => 'badge-gradient-success',
                                        'completed' => 'badge-gradient-info',
                                        'cancelled' => 'badge-gradient-danger',
                                        default => 'badge-gradient-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td><span class="badge badge-light fw-bold text-dark">#{{ $r->id }}</span></td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $r->name ?: 'Client invité' }}</div>
                                        <small class="text-muted">{{ $r->phone ?: '' }}</small>
                                    </td>
                                    <td>
                                        <i class="mdi mdi-account text-primary me-1"></i> {{ $r->barberMan?->name ?: '—' }}
                                    </td>
                                    <td>
                                        <div>{{ \Carbon\Carbon::parse($r->dateReservation)->format('d M Y') }}</div>
                                        <small class="text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $r->time }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">{{ number_format($r->price, 0) }} DH</span>
                                    </td>
                                    <td>
                                        <label class="badge {{ $badge }} text-uppercase px-2 py-1" style="font-size: 0.7rem;">
                                            {{ $r->status ?: 'confirmed' }}
                                        </label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="mdi mdi-calendar-blank fs-2 d-block mb-2"></i>
                                        Aucune réservation pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- État & Répartition des Rendez-vous -->
    <div class="col-lg-4 grid-margin stretch-card">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-body">
                <h4 class="card-title fw-bold text-dark mb-1">État des Réservations</h4>
                <p class="text-muted small mb-4">Répartition des rendez-vous par statut</p>

                @php
                    $total = max($stats['total'] ?? 1, 1);
                    $confPct = round((($stats['confirmed'] ?? 0) / $total) * 100);
                    $compPct = round((($stats['completed'] ?? 0) / $total) * 100);
                    $cancPct = round((($stats['cancelled'] ?? 0) / $total) * 100);
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-semibold text-dark"><i class="mdi mdi-check-circle text-success me-1"></i> Confirmées</span>
                        <span class="fw-bold text-success">{{ $stats['confirmed'] ?? 0 }} ({{ $confPct }}%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-gradient-success" role="progressbar" style="width: {{ $confPct }}%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-semibold text-dark"><i class="mdi mdi-check-all text-info me-1"></i> Terminées</span>
                        <span class="fw-bold text-info">{{ $stats['completed'] ?? 0 }} ({{ $compPct }}%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-gradient-info" role="progressbar" style="width: {{ $compPct }}%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-semibold text-dark"><i class="mdi mdi-close-circle text-danger me-1"></i> Annulées</span>
                        <span class="fw-bold text-danger">{{ $stats['cancelled'] ?? 0 }} ({{ $cancPct }}%)</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-gradient-danger" role="progressbar" style="width: {{ $cancPct }}%"></div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-gradient-primary btn-sm py-2">
                        <i class="mdi mdi-calendar-search me-1"></i> Accéder au Gestionnaire Complet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
