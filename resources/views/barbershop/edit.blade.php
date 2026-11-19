@extends('layout.primary')

@section('title', 'Liste des utilisateurs')

@section('content')
<h2 class="mb-4 fw-bold text-dark">List des utilisateur</h2>

<div class="card-custom">
    <div class="mb-4">
        <a href="{{ route('barbershop.index') }}" class="text-decoration-none fw-bold" style="color: #9a55ff;">
            Retour à la page d'index des barbiers
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
                    <form method="post" action="{{ route('barbershop.update', ['barbershop' => $barbershop->id]) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $barbershop->id }}">
                        <div class="mb-3">
                            <label for="name" class="form-label text-secondary fw-bold">name</label>
                            <input type="text" class="form-control bg-light border-0" id="name" name="name" value="{{ $barbershop->name }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label text-secondary fw-bold">address</label>
                            <input type="text" class="form-control bg-light border-0" id="address" name="address" value="{{ $barbershop->address }}" required />
                        </div>
                        <div class="mb-4">
                            <label for="city" class="form-label text-secondary fw-bold">city</label>
                            <input type="text" class="form-control bg-light border-0" id="city" name="city" value="{{ $barbershop->city }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="zip" class="form-label text-secondary fw-bold">zip</label>
                            <input type="text" class="form-control bg-light border-0" id="zip" name="zip" value="{{ $barbershop->zip }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label text-secondary fw-bold">Latitude</label>
                            <input type="text" class="form-control bg-light border-0" id="latitude" name="latitude" value="{{ $barbershop->latitude }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="Longitude" class="form-label text-secondary fw-bold">Longitude</label>
                            <input type="text" class="form-control bg-light border-0" id="Longitude" name="Longitude" value="{{ $barbershop->Longitude }}" required />
                        </div>
                        <div class="mb-3">
                            <button type="submit" href="{{ route('barbershop.index') }}" class="btn btn-primary">Mettre à jour</button>
                        </div>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
