@extends("layout.primary")
@section("title")
BarberShop - Barbers
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="card-title mb-0">Barbers</h4>
        <a href="{{ route('barbermen.create') }}" class="btn btn-gradient-primary btn-sm">
          <i class="mdi mdi-plus me-1"></i> Ajouter un barber
        </a>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th> # </th>
              <th> Name </th>
              <th> BarberShop </th>
              <th> Created At </th>
              <th> Actions </th>
            </tr>
          </thead>
          <tbody>
            @forelse($barberMen as $barberMan)
              <tr>
                <td>{{ $barberMan->id }}</td>
                <td>{{ $barberMan->name }}</td>
                <td>{{ $barberMan->barberShop?->name ?? '-' }}</td>
                <td>{{ $barberMan->created_at?->format('d M, Y') ?? '-' }}</td>
                <td>
                  <a href="{{ route('barbermen.show', $barberMan) }}" class="btn btn-gradient-success btn-sm">
                    <i class="mdi mdi-eye"></i>
                  </a>
                  <a href="{{ route('barbermen.edit', $barberMan) }}" class="btn btn-gradient-info btn-sm">
                    <i class="mdi mdi-pencil"></i>
                  </a>
                  <form action="{{ route('barbermen.destroy', $barberMan) }}" method="post" class="d-inline"
                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce barber ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-gradient-danger btn-sm">
                      <i class="mdi mdi-delete"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Aucun barber pour le moment.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $barberMen->links() }}
      </div>
    </div>
  </div>
</div>
@endsection