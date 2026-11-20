@extends('layout.primary')

@section('title', 'Liste des barbershops')

@section('content')
<h2 class="mb-4 fw-bold text-dark">List des barbershops</h2>

<div class="card-custom">
    <div class="mb-4">
        <a href="{{ route('barbershop.create') }}" class="text-decoration-none fw-bold" style="color: #9a55ff;">
            Ajouter un nouveau barbershop
        </a>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr class="text-muted">
                    <th>name</th>
                    <th>city</th>
                    <th>address</th>
                    <th>zip</th>
                    <th>latitude</th>
                    <th>longitude</th>
                    <th>afficher</th>
                    <th>modifier</th>
                    <th>supprimer</th>
                    <th>Services</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barbershops as $barbershop)
                <tr>
                    <td>{{ $barbershop->name }}</td>
                    <td>{{ $barbershop->city }}</td>
                    <td>{{ $barbershop->address }}</td>
                    <td>{{ $barbershop->zip }}</td>
                    <td>{{ $barbershop->latitude }}</td>
                    <td>{{ $barbershop->Longitude }}</td>
                    <td>
                        <a href="{{ route('barbershop.show', ['barbershop' => $barbershop->id]) }}" class="text-decoration-none" style="color: #9a55ff;">
                            Afficher
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('barbershop.edit', ['barbershop' => $barbershop->id]) }}" class="text-decoration-none text-primary">
                            modifier
                        </a>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('barbershop.destroy', ['barbershop' => $barbershop->id]) }}">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-light border">delete</button>
                        </form>
                    </td>
                       <td>
                        <a href="{{ route('bareberservice', ['id' => $barbershop->id]) }}" class="text-decoration-none text-primary">
                            Services
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $barbershops->links() }}
        </div>
    </div>
</div>
@endsection