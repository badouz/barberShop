@extends("layout.primary")

@section("title")
Dashboard Réservations - {{ auth()->user()->isBarberShop() ? (auth()->user()->barberShops->first()?->name ?? 'Mon Salon') : 'Administration' }}
@endsection

@section("content")
@php
    $isShop = auth()->user()->isBarberShop();
    $currentShop = $isShop ? auth()->user()->barberShops->first() : null;
    $activeStatus = request('status', '');
@endphp

<!-- En-tête / Header du Dashboard -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-gradient-primary text-white border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; position: relative;">
            <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute position-absolute" style="top: 0; right: 0; height: 100%; opacity: 0.25; pointer-events: none;" alt="circle-bg" />
            <div class="card-body p-4 position-relative">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <span class="badge bg-white text-primary fw-bold text-uppercase mb-2 px-3 py-2" style="letter-spacing: 0.5px;">
                            <i class="mdi mdi-shield-check me-1"></i> {{ $isShop ? 'Espace Salon de Coiffure' : 'Super Administration' }}
                        </span>
                        <h2 class="fw-bold mb-1 text-white">
                            {{ $isShop ? ($currentShop?->name ?? 'Mon Salon') : 'Tableau de Bord Global' }}
                        </h2>
                        <p class="mb-0 text-white-50">
                            {{ $isShop ? 'Suivez vos réservations, vos revenus et vos rendez-vous clients en temps réel.' : 'Supervision complète de l’ensemble des salons, des réservations et du chiffre d’affaires.' }}
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0 text-md-end">
                        <div class="d-inline-flex align-items-center bg-white bg-opacity-10 px-3 py-2 rounded text-white">
                            <i class="mdi mdi-calendar-today me-2 fs-5"></i>
                            <span class="fw-semibold">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4 Cartes KPI Stylées Purple Gradient -->
<div class="row mb-4">
    <!-- Chiffre d'affaires -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card bg-gradient-success card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Chiffre d'Affaires <i class="mdi mdi-cash-multiple mdi-24px float-end"></i></h4>
                <h2 class="mb-2 fw-bold">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} DH</h2>
                <h6 class="card-text text-white-50 small mb-0"><i class="mdi mdi-check-circle me-1"></i> Confirmé & Terminé</h6>
            </div>
        </div>
    </div>

    <!-- Total Réservations -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card bg-gradient-primary card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Total Réservations <i class="mdi mdi-calendar-check mdi-24px float-end"></i></h4>
                <h2 class="mb-2 fw-bold">{{ $stats['total'] ?? 0 }}</h2>
                <h6 class="card-text text-white-50 small mb-0"><i class="mdi mdi-clock-outline me-1"></i> Aujourd'hui : {{ $stats['today'] ?? 0 }}</h6>
            </div>
        </div>
    </div>

    <!-- Confirmées -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card bg-gradient-info card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Confirmées <i class="mdi mdi-check-decagram mdi-24px float-end"></i></h4>
                <h2 class="mb-2 fw-bold">{{ $stats['confirmed'] ?? 0 }}</h2>
                <h6 class="card-text text-white-50 small mb-0"><i class="mdi mdi-account-check me-1"></i> Prêtes pour le service</h6>
            </div>
        </div>
    </div>

    <!-- Annulées -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
        <div class="card bg-gradient-danger card-img-holder text-white shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h4 class="font-weight-normal mb-3">Annulées <i class="mdi mdi-close-circle-outline mdi-24px float-end"></i></h4>
                <h2 class="mb-2 fw-bold">{{ $stats['cancelled'] ?? 0 }}</h2>
                <h6 class="card-text text-white-50 small mb-0"><i class="mdi mdi-alert-circle-outline me-1"></i> Créneaux libérés</h6>
            </div>
        </div>
    </div>
</div>

<!-- Table Card avec Filtres -->
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-4">
                <!-- En-tête de la table & Boutons de filtres -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                    <div>
                        <h4 class="card-title mb-1 fw-bold text-dark">
                            <i class="mdi mdi-format-list-bulleted text-primary me-2"></i> Liste des Réservations
                        </h4>
                        <p class="text-muted small mb-0">
                            {{ $isShop ? 'Gérez le statut de vos clients et consultez les détails de chaque rendez-vous.' : 'Gestion centralisée de toutes les réservations du réseau.' }}
                        </p>
                    </div>

                    <!-- Filtres par statut -->
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm {{ $activeStatus === '' ? 'btn-gradient-primary' : 'btn-outline-secondary' }}">
                            Toutes <span class="badge bg-light text-dark ms-1">{{ $stats['total'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.reservations.index', ['status' => 'confirmed']) }}" class="btn btn-sm {{ $activeStatus === 'confirmed' ? 'btn-gradient-success' : 'btn-outline-secondary' }}">
                            Confirmées <span class="badge bg-light text-dark ms-1">{{ $stats['confirmed'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.reservations.index', ['status' => 'completed']) }}" class="btn btn-sm {{ $activeStatus === 'completed' ? 'btn-gradient-info' : 'btn-outline-secondary' }}">
                            Terminées <span class="badge bg-light text-dark ms-1">{{ $stats['completed'] ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.reservations.index', ['status' => 'cancelled']) }}" class="btn btn-sm {{ $activeStatus === 'cancelled' ? 'btn-gradient-danger' : 'btn-outline-secondary' }}">
                            Annulées <span class="badge bg-light text-dark ms-1">{{ $stats['cancelled'] ?? 0 }}</span>
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="mdi mdi-check-circle-outline fs-4 me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th>Salon</th>
                                <th>Barbier</th>
                                <th>Prestations</th>
                                <th>Date & Heure</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th class="text-center">Changer Statut / Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $res)
                                @php
                                    $shop = $res->barberMan?->barberShop;
                                    $statusBadgeClass = match($res->status) {
                                        'confirmed' => 'badge-gradient-success',
                                        'completed' => 'badge-gradient-info',
                                        'cancelled' => 'badge-gradient-danger',
                                        default => 'badge-gradient-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <span class="badge badge-light text-dark fw-bold">#{{ $res->id }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $res->name ?: 'Client invité' }}</div>
                                    </td>
                                    <td>
                                        @if($res->phone)
                                            <a href="tel:{{ $res->phone }}" class="text-decoration-none text-muted">
                                                <i class="mdi mdi-phone me-1 text-primary"></i>{{ $res->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-primary">{{ $shop?->name ?: 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="mdi mdi-account text-primary"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $res->barberMan?->name ?: 'Non assigné' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @forelse($res->services as $svc)
                                            <span class="badge badge-light border mb-1 me-1">{{ $svc->name }}</span>
                                        @empty
                                            <span class="text-muted small">Aucun service</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($res->dateReservation)->format('d M Y') }}</div>
                                        <small class="text-muted"><i class="mdi mdi-clock-outline me-1 text-primary"></i>{{ $res->time }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success fs-6">{{ number_format($res->price, 0) }} DH</span>
                                    </td>
                                    <td>
                                        <label class="badge {{ $statusBadgeClass }} px-3 py-2" style="font-size: 0.75rem;">
                                            {{ ucfirst($res->status ?: 'confirmed') }}
                                        </label>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            <!-- Bouton Changer Statut Dropdown -->
                                            <div class="dropdown d-inline">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle py-1 px-2" type="button" id="statusDropdown{{ $res->id }}" data-bs-toggle="dropdown" aria-expanded="false" title="Changer le statut">
                                                    Statut
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="statusDropdown{{ $res->id }}">
                                                    <li>
                                                        <form action="{{ route('admin.reservations.status', $res->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="dropdown-item text-success {{ $res->status === 'confirmed' ? 'active' : '' }}">
                                                                <i class="mdi mdi-check-circle me-2"></i> Confirmer
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.reservations.status', $res->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="dropdown-item text-info {{ $res->status === 'completed' ? 'active' : '' }}">
                                                                <i class="mdi mdi-check-all me-2"></i> Marquer Terminé
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li><hr class="dropdown-divider my-1"></li>
                                                    <li>
                                                        <form action="{{ route('admin.reservations.status', $res->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="dropdown-item text-danger {{ $res->status === 'cancelled' ? 'active' : '' }}">
                                                                <i class="mdi mdi-close-circle me-2"></i> Annuler
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Bouton Supprimer -->
                                            <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger p-2" title="Supprimer la réservation">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-calendar-blank-outline display-4 d-block mb-3 text-secondary"></i>
                                        <h5 class="fw-bold">Aucune réservation trouvée</h5>
                                        <p class="small text-muted mb-0">Les rendez-vous pris par vos clients apparaîtront ici automatiquement.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reservations->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $reservations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
