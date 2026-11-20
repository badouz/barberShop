@extends("layout.primary")

@section("title")
Reservations Management - BarberShop
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1">Reservations List</h4>
                    <p class="card-description mb-0">View and manage customer appointments across all barber shops</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Barber Shop</th>
                            <th>Barber</th>
                            <th>Services</th>
                            <th>Date & Time</th>
                            <th>Total (DH)</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
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
                                    <span class="fw-bold text-dark">{{ $res->name ?: 'Guest' }}</span>
                                </td>
                                <td>
                                    <a href="tel:{{ $res->phone }}" class="text-decoration-none text-muted">
                                        <i class="mdi mdi-phone me-1"></i>{{ $res->phone ?: '—' }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge badge-outline-primary">{{ $shop?->name ?: 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-account-circle me-1 text-primary fs-5"></i>
                                        <span>{{ $res->barberMan?->name ?: 'Unassigned' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @foreach($res->services as $svc)
                                        <span class="badge badge-light border mb-1 me-1">{{ $svc->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ \Carbon\Carbon::parse($res->dateReservation)->format('d M Y') }}</div>
                                    <small class="text-muted"><i class="mdi mdi-clock-outline me-1"></i>{{ $res->time }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-success fs-6">{{ $res->price }} DH</span>
                                </td>
                                <td>
                                    <label class="badge {{ $statusBadgeClass }}">{{ ucfirst($res->status ?: 'confirmed') }}</label>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.reservations.destroy', $res->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this reservation?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger p-2" title="Delete reservation">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="mdi mdi-calendar-blank fs-2 d-block mb-2"></i>
                                    No reservations found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
