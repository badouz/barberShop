@extends('layout.primary')

@section('title', 'Ajouter barbershop')

@section('content')
<h2 class="mb-4 fw-bold text-dark">ajauter un nouveau Barbershop</h2>

<div class="card-custom">
    <h5 class="fw-bold mb-1">Default Form</h5>
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <form method="POST" action="{{ route('barbershop.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label text-secondary fw-bold">name</label>
            <input type="text" class="form-control bg-light border-0" id="name" name="name" required />
        </div>

        <div class="mb-3">
            <label for="address" class="form-label text-secondary fw-bold">address</label>
            <input type="text" class="form-control bg-light border-0" id="address" name="address" required />
        </div>

        <div class="mb-4">
            <label for="city" class="form-label text-secondary fw-bold">city</label>
            <input type="text" class="form-control bg-light border-0" id="city" name="city" required />
        </div>

        <div class="mb-3">
            <label for="zip" class="form-label text-secondary fw-bold">zip</label>
            <input type="text" class="form-control bg-light border-0" id="zip" name="zip" required />
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label text-secondary fw-bold">Latitude</label>
            <input type="text" class="form-control bg-light border-0" id="latitude" name="latitude" required />
        </div>

        <div class="mb-4">
            <label for="Longitude" class="form-label text-secondary fw-bold">Longitude</label>
            <input type="text" class="form-control bg-light border-0" id="Longitude" name="Longitude" required />
        </div>
        <div class="mb-4">
            <label for="user_id" class="form-label text-secondary fw-bold">user_id</label>
            <input type="number" class="form-control bg-light border-0" id="user_id" name="user_id" required />
        </div>

        <button type="submit" class="btn btn-purple px-4">Créer barbershop</button>
    </form>
</div>
@endsection