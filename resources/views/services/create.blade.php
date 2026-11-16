@extends("layout.primary")

@section("title")
Add New Service - BarberShop
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1">Add New Service</h4>
                    <p class="card-description mb-0">Create a new service with pricing, duration, and photos</p>
                </div>
                <a href="{{ route('services.index') }}" class="btn btn-light btn-icon-text">
                    <i class="mdi mdi-arrow-left me-1"></i> Back to Services
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-bold">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Classic Beard Trim & Shave" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="barbershop_id" class="fw-bold">Barber Shop <span class="text-danger">*</span></label>
                            <select name="barbershop_id" id="barbershop_id" class="form-select form-control @error('barbershop_id') is-invalid @enderror" required>
                                <option value="">-- Select Barber Shop --</option>
                                @foreach($barbershops as $shop)
                                    <option value="{{ $shop->id }}" {{ old('barbershop_id') == $shop->id ? 'selected' : '' }}>
                                        {{ $shop->name }} ({{ $shop->city ?? 'No city' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('barbershop_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="price" class="fw-bold">Price ($) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="25.00" required>
                            </div>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="duration" class="fw-bold">Duration (in minutes) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" min="1" step="5" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', 30) }}" placeholder="30" required>
                                <span class="input-group-text">mins</span>
                            </div>
                            @error('duration')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="images" class="fw-bold">Service Photos (Upload Multiple)</label>
                    <input type="file" name="images[]" id="images" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                    <small class="text-muted d-block mt-1">
                        <i class="mdi mdi-information-outline"></i> You can select multiple images (JPEG, PNG, JPG, WEBP). The first uploaded image will automatically be set as the primary photo.
                    </small>
                    @error('images.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient-primary me-2">
                        <i class="mdi mdi-content-save me-1"></i> Save Service
                    </button>
                    <a href="{{ route('services.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
