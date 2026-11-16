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
                    <th>Password</th>
                    <th>Confirmé</th>
                </tr>
            </thead>
            
            <tbody>

                <tr>
                    <form method="post" action="{{ route('users.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('PUT')
                        <td><input type="text" name="name" value="{{ $user->name }}"></td>
                        <td><input type="email" name="email" value="{{ $user->email }}"></td>
                        <td>
                            <input type="password" name="password" placeholder="Nouveau mot de passe (optionnel)" class="form-control form-control-sm mb-2">
                        </td>
                        <td>
                            <input type="submit" value="Confirmer">
                        </td>
                    </form>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
