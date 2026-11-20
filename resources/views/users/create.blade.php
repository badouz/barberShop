@extends('layout.primary')

@section('title', 'Ajouter un utilisateur')

@section('content')
<h2 class="mb-4 fw-bold text-dark">ajouter un nouveau utilisateur</h2>

<div class="card-custom">
    <h5 class="fw-bold mb-1">Default Form</h5>
    <p class="text-muted small mb-4">Basic form layout</p>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        @csrf
                  <div class="form-group">
                    <input name="name" type="text" class="form-control form-control-lg" placeholder="Name">
                  </div>
                  <div class="form-group">
                    <input name="phone" type="number" class="form-control form-control-lg" placeholder="phone">
                  </div>
                  <div class="form-group">
                    <input name="city" type="text" class="form-control form-control-lg" placeholder="city">
                  </div>
                  <div class="form-group">
                    <input name="address" type="text" class="form-control form-control-lg" placeholder="address">
                  </div>
                  <div class="form-group">
                    <input name="zip" type="text" class="form-control form-control-lg" placeholder="zip">
                  </div>
                  <div class="form-group">
                    <input name="email" type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input name="password" type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                  </div>

        <button type="submit" class="btn btn-purple px-4">Envoyer</button>
    </form>
</div>
@endsection