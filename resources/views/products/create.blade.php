@extends('layouts.primary')

@section('title', 'Ajouter un produit')

@section('content')
<h2 class="mb-4 fw-bold text-dark">Ajouter un produit</h2>

<div class="card-custom">
    <form method="POST" action="{{ route('services.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-secondary fw-bold">Nom</label>
            <input type="text" class="form-control bg-light border-0" id="name" name="name" value="{{ old('name') }}" maxlength="255" required>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label text-secondary fw-bold">Description</label>
            <textarea class="form-control bg-light border-0" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="form-label text-secondary fw-bold">Prix</label>
            <input type="number" class="form-control bg-light border-0" id="price" name="price" value="{{ old('price') }}" min="0" max="999999.99" step="0.01" required>
            @error('price')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-purple px-4">Enregistrer</button>
        <a href="{{ route('services.index') }}" class="btn btn-light border ms-2">Annuler</a>
    </form>
</div>
@endsection
