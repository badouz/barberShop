@extends('layouts.primary')

@section('title', 'Ajouter un utilisateur')

@section('content')
<h2 class="mb-4 fw-bold text-dark">ajputer un nouveau utilisateur</h2>

<div class="card-custom">
    <h5 class="fw-bold mb-1">Default Form</h5>
    <p class="text-muted small mb-4">Basic form layout</p>

    <form method="POST" action="{{ route('barbershop.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-secondary fw-bold">name</label>
            <input type="text" class="form-control bg-light border-0" id="name" name="name" required />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-secondary fw-bold">email</label>
            <input type="email" class="form-control bg-light border-0" id="email" name="email" required />
        </div>

        <div class="mb-4">
            <label for="password" class="form-label text-secondary fw-bold">password</label>
            <input type="password" class="form-control bg-light border-0" id="password" name="password" required />
        </div>

        <div class="mb-3">
            <label for="name" class="form-label text-secondary fw-bold">name</label>
            <input type="text" class="form-control bg-light border-0" id="name" name="name" required />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-secondary fw-bold">email</label>
            <input type="email" class="form-control bg-light border-0" id="email" name="email" required />
        </div>

        <div class="mb-4">
            <label for="password" class="form-label text-secondary fw-bold">password</label>
            <input type="password" class="form-control bg-light border-0" id="password" name="password" required />
        </div>

        <button type="submit" class="btn btn-purple px-4">Envoyer</button>
    </form>
</div>
@endsection
