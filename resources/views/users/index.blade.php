@extends('layouts.primary')

@section('title', 'Liste des utilisateurs')

@section('content')
<h2 class="mb-4 fw-bold text-dark">List des utilisateur</h2>

<div class="card-custom">
    <div class="mb-4">
        <a href="{{ route('users.create') }}" class="text-decoration-none fw-bold" style="color: #9a55ff;">
            Ajouter un nouveau utilisateur
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="text-muted">
                    <th>name</th>
                    <th>email</th>
                    <th>date création</th>
                    <th>afficher</th>
                    <th>modifier</th>
                    <th>supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <a href="{{ route('users.show', ['user' => $user->id]) }}" class="text-decoration-none" style="color: #9a55ff;">
                            Afficher
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="text-decoration-none text-primary">
                            modifier
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-light border">delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection