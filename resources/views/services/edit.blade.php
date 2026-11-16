@extends("layout.primary")

@section("title")
Edit Service: {{ $service->name }} - BarberShop
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1">Edit Service: {{ $service->name }}</h4>
                    <p class="card-description mb-0">Update service information and manage gallery photos</p>
                </div>
                <a href="{{ route('services.index') }}" class="btn btn-light btn-icon-text">
                    <i class="mdi mdi-arrow-left me-1"></i> Back to Services
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mdi mdi-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

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

            <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-bold">Service Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $service->name) }}" required>
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
                                    <option value="{{ $shop->id }}" {{ old('barbershop_id', $service->barbershop_id) == $shop->id ? 'selected' : '' }}>
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
                                <input type="number" step="0.01" min="0" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $service->price) }}" required>
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
                                <input type="number" min="1" step="5" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', $service->duration) }}" required>
                                <span class="input-group-text">mins</span>
                            </div>
                            @error('duration')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="images" class="fw-bold">Upload Additional Photos</label>
                    <input type="file" name="images[]" id="images" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                    <small class="text-muted d-block mt-1">Select one or multiple photos to add to this service's photo gallery.</small>
                    @error('images.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-gradient-primary me-2">
                        <i class="mdi mdi-content-save me-1"></i> Update Service
                    </button>
                    <a href="{{ route('services.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>

            <hr class="my-4">

            <div class="mt-4">
                <h5 class="mb-3"><i class="mdi mdi-image-multiple text-primary me-1"></i> Current Gallery Photos ({{ $service->serviceImages->count() }})</h5>

                @if($service->serviceImages->isEmpty())
                    <p class="text-muted">No photos uploaded for this service yet.</p>
                @else
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                        @foreach($service->serviceImages as $img)
                            <div class="col">
                                <div class="card h-100 border shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $img->path) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Service Image">
                                        @if($img->is_primary)
                                            <span class="badge badge-gradient-success position-absolute top-0 start-0 m-2">
                                                <i class="mdi mdi-star"></i> Primary
                                            </span>
                                        @endif
                                    </div>
                                    <div class="card-body p-2 d-flex justify-content-between align-items-center">
                                        @if(!$img->is_primary)
                                            <form action="{{ route('services.images.primary', $img) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-xs btn-outline-primary" title="Set as primary image">
                                                    <i class="mdi mdi-star-outline"></i> Set Primary
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-success small fw-bold"><i class="mdi mdi-check"></i> Active Primary</span>
                                        @endif

                                        <form action="{{ route('services.images.destroy', $img) }}" method="POST" onsubmit="return confirm('Delete this image?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Delete image">
                                                <i class="mdi mdi-delete"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
