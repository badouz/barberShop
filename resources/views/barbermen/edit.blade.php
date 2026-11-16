<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit barber</title>
</head>
<body>
    <h1>Edit barber</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('barbermen.update', $barberMan) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name', $barberMan->name) }}"><br><br>

        <label>Barbershop</label><br>
        <select name="barbershop_id">
            @foreach($allBarberShops as $barberShop)
                <option value="{{ $barberShop->id }}" @selected(old('barbershop_id', $barberMan->barbershop_id) == $barberShop->id)>
                    {{ $barberShop->name }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Update</button>
        <a href="{{ route('barbermen.index') }}">Cancel</a>
    </form>
</body>
</html>