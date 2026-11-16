@extends('layouts.primary')

@section('title', 'Liste des utilisateurs')

@section('content')
<h2 class="mb-4 fw-bold text-dark">List des utilisateur</h2>

<div class="card-custom">
    <div class="mb-4">
        <a href="{{ route('users.index') }}" class="text-decoration-none fw-bold" style="color: #9a55ff;">
            Retour à la page d'index des utilisateurs
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="text-muted">
                    <th>name</th>
                    <th>email</th>
                </tr>
            </thead>
            
            <tbody>

                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
