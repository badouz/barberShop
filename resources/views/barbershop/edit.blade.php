@extends('layout.primary')

@section('title', 'Modifier Barbershop')

@section('content')
<div class="col-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="card-title mb-1">Modifier le Barbershop : {{ $barbershop->name }}</h4>
                    <p class="card-description mb-0">Mettre à jour les informations et coordonnées GPS</p>
                </div>
                <a href="{{ route('barbershop.index') }}" class="btn btn-light btn-icon-text">
                    <i class="mdi mdi-arrow-left me-1"></i> Retour à la liste
                </a>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('barbershop.update', $barbershop) }}" class="forms-sample">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $barbershop->name) }}" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="city" class="form-label fw-bold">Ville <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $barbershop->city) }}" required />
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="address" class="form-label fw-bold">Adresse <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $barbershop->address) }}" required />
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="zip" class="form-label fw-bold">Code Postal (ZIP) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip', $barbershop->zip) }}" required />
                            @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="latitude" class="form-label fw-bold">Latitude (coordonnée décimale) <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $barbershop->latitude) }}" required />
                            <small class="text-muted">Doit être un nombre décimal (ex: 32.2345).</small>
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="Longitude" class="form-label fw-bold">Longitude (coordonnée décimale) <span class="text-danger">*</span></label>
                            <input type="number" step="any" class="form-control @error('Longitude') is-invalid @enderror" id="Longitude" name="Longitude" value="{{ old('Longitude', $barbershop->Longitude) }}" required />
                            <small class="text-muted">Doit être un nombre décimal (ex: -7.9532).</small>
                            @error('Longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient-primary me-2">
                        <i class="mdi mdi-content-save me-1"></i> Mettre à jour
                    </button>
                    <a href="{{ route('barbershop.index') }}" class="btn btn-light">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
