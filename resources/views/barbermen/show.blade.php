@extends("layout.primary")
@section("title")
BarberShop - Barber
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title mb-0">{{ $barberMan->name }}</h4>
        <div>
          <a href="{{ route('barbermen.edit', $barberMan) }}" class="btn btn-gradient-info btn-sm">
            <i class="mdi mdi-pencil me-1"></i> Modifier
          </a>
          <a href="{{ route('barbermen.index') }}" class="btn btn-light btn-sm">Retour</a>
        </div>
      </div>

      <table class="table">
        <tbody>
          <tr>
            <th style="width: 200px;">ID</th>
            <td>{{ $barberMan->id }}</td>
          </tr>
          <tr>
            <th>Name</th>
            <td>{{ $barberMan->name }}</td>
          </tr>
          <tr>
            <th>BarberShop</th>
            <td>{{ $barberMan->barberShop?->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Created At</th>
            <td>{{ $barberMan->created_at?->format('d M, Y') ?? '-' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection