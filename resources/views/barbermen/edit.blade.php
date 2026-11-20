@extends("layout.primary")
@section("title")
BarberShop - Modifier un barber
@endsection

@section("content")
<div class="col-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Modifier le barber</h4>

      @if($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form class="forms-sample" action="{{ route('barbermen.update', $barberMan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror"
                 id="name" name="name" value="{{ old('name', $barberMan->name) }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="barbershop_id">BarberShop</label>
          <select class="form-select @error('barbershop_id') is-invalid @enderror"
                  id="barbershop_id" name="barbershop_id">
            @foreach($allBarberShops as $barberShop)
              <option value="{{ $barberShop->id }}"
                @selected(old('barbershop_id', $barberMan->barbershop_id) == $barberShop->id)>
                {{ $barberShop->name }}
              </option>
            @endforeach
          </select>
          @error('barbershop_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-gradient-primary me-2">Mettre à jour</button>
        <a href="{{ route('barbermen.index') }}" class="btn btn-light">Annuler</a>
      </form>
    </div>
  </div>
</div>
@endsection