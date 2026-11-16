@extends("layout.primary")

@section("title")
Services Management - BarberShop
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1">Services List</h4>
                    <p class="card-description mb-0">Manage services offered by your barber shops</p>
                </div>
                <a href="{{ route('services.create') }}" class="btn btn-gradient-primary btn-icon-text">
                    <i class="mdi mdi-plus-circle me-1"></i> Add New Service
                </a>
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
                            <th>Image</th>
                            <th>Service Name</th>
                            <th>Barber Shop</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Total Photos</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>{{ $service->id }}</td>
                                <td>
                                    @php
                                        $primary = $service->primaryImage ?? $service->serviceImages->first();
                                    @endphp
                                    @if($primary && $primary->path)
                                        <img src="{{ asset('storage/' . $primary->path) }}" alt="{{ $service->name }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                            <i class="mdi mdi-content-cut fs-4"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">{{ $service->name }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-gradient-info">
                                        <i class="mdi mdi-store me-1"></i> {{ $service->barberShop->name ?? 'No Shop Assigned' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">${{ number_format($service->price, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-muted"><i class="mdi mdi-clock-outline me-1"></i> {{ $service->duration }} mins</span>
                                </td>
                                <td>
                                    <span class="badge badge-gradient-primary">
                                        <i class="mdi mdi-image-multiple me-1"></i> {{ $service->serviceImages->count() }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-outline-warning" title="Edit Service">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Service">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="mdi mdi-content-cut fs-1 d-block mb-2 text-secondary"></i>
                                    <h5>No services found</h5>
                                    <p class="mb-3">Start by creating your first barber shop service.</p>
                                    <a href="{{ route('services.create') }}" class="btn btn-gradient-primary btn-sm">
                                        <i class="mdi mdi-plus"></i> Add Service Now
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-end">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
