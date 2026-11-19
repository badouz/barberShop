@extends('layouts.primary')

@section('title', 'Produits')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">Produits</h2>
    <a href="{{ route('services.create') }}" class="btn btn-purple px-4">Ajouter un produit</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card-custom">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="text-muted">
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ number_format((float) $product->price, 2) }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('services.show', $product) }}" class="btn btn-sm btn-light border">Afficher</a>
                            <a href="{{ route('services.edit', $product) }}" class="btn btn-sm btn-light border">Modifier</a>
                            <form method="POST" action="{{ route('services.destroy', $product) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Aucun produit enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($products->hasPages())
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <p class="text-muted mb-0">
                Produits {{ $products->firstItem() }} à {{ $products->lastItem() }} sur {{ $products->total() }}
            </p>
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
