<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add barber</title>
</head>
<body>
    <h1>Add barber</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('barbermen.store') }}" method="POST">
        @csrf

        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name') }}"><br><br>

        <label>Barbershop</label><br>
        <select name="barbershop_id">
            <option value="">-- choose --</option>
            @foreach($allBarberShops as $barberShop)
                <option value="{{ $barberShop->id }}" @selected(old('barbershop_id') == $barberShop->id)>
                    {{ $barberShop->name }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Save</button>
        <a href="{{ route('barbermen.index') }}">Cancel</a>
    </form>
</body>
</html>