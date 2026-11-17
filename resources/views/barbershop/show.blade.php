@extends('layout.primary')

@section('title', 'Détails du barbier')

@section('content')
<h2 class="mb-4 fw-bold text-dark">Détails du barbier</h2>

<div class="card-custom">
    <div class="mb-4">
        <a href="{{ route('barbershop.index') }}" class="text-decoration-none fw-bold" style="color: #9a55ff;">
            Retour à la page d'index des barbiers
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="text-muted">
                    <th>Nom</th>
                    <th>Ville</th>
                    <th>Adresse</th>
                    <th>Zip</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $barbershop->name }}</td>
                    <td>{{ $barbershop->city }}</td>
                    <td>{{ $barbershop->address }}</td>
                    <td>{{ $barbershop->zip }}</td>
                    <td>{{ $barbershop->latitude }}</td>
                    <td>{{ $barbershop->Longitude }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection