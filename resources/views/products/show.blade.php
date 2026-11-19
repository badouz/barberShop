@extends('layouts.primary')

@section('title', 'Détails du produit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Détails du produit</h2>
    <div>
        <a href="{{ route('services.edit', $product) }}" class="btn btn-purple px-4">Modifier</a>
        <a href="{{ route('services.index') }}" class="btn btn-light border ms-2">Retour</a>
    </div>
</div>

<div class="card-custom">
    <dl class="row mb-0">
        <dt class="col-sm-3">Nom</dt>
        <dd class="col-sm-9">{{ $product->name }}</dd>

        <dt class="col-sm-3">Description</dt>
        <dd class="col-sm-9">{{ $product->description }}</dd>

        <dt class="col-sm-3">Prix</dt>
        <dd class="col-sm-9">{{ number_format((float) $product->price, 2) }}</dd>
    </dl>
</div>
@endsection
