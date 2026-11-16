@extends("layout.primary")

@section("title")
{{ $service->name }} Details - BarberShop
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1">{{ $service->name }}</h4>
                    <p class="card-description mb-0">Detailed view of service information and photo gallery</p>
                </div>
                <div>
                    <a href="{{ route('services.edit', $service) }}" class="btn btn-gradient-warning btn-icon-text me-2">
                        <i class="mdi mdi-pencil me-1"></i> Edit Service
                    </a>
                    <a href="{{ route('services.index') }}" class="btn btn-light btn-icon-text">
                        <i class="mdi mdi-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase mb-2">Price</h6>
                            <h2 class="text-success font-weight-bold mb-0">${{ number_format($service->price, 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase mb-2">Duration</h6>
                            <h2 class="text-info font-weight-bold mb-0">{{ $service->duration }} <small class="text-muted fs-6">minutes</small></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase mb-2">Barber Shop</h6>
                            <h3 class="text-dark font-weight-bold mb-0">{{ $service->barberShop->name ?? 'N/A' }}</h3>
                            <small class="text-muted">{{ $service->barberShop->city ?? '' }} {{ $service->barberShop->address ?? '' }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3"><i class="mdi mdi-camera me-1 text-primary"></i> Photos Gallery ({{ $service->serviceImages->count() }})</h5>

            @if($service->serviceImages->isEmpty())
                <div class="text-center py-4 text-muted bg-light rounded">
                    <i class="mdi mdi-image-off fs-1 d-block mb-2"></i>
                    No photos uploaded for this service yet.
                </div>
            @else
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    @foreach($service->serviceImages as $img)
                        <div class="col">
                            <div class="card h-100 shadow-sm border overflow-hidden">
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $img->path) }}" class="card-img-top" style="height: 220px; object-fit: cover;" alt="{{ $service->name }}">
                                    @if($img->is_primary)
                                        <span class="badge badge-gradient-success position-absolute top-0 start-0 m-2">
                                            <i class="mdi mdi-star"></i> Primary Photo
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
