<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barber</title>
</head>
<body>
    <h1>{{ $barberMan->name }}</h1>
    <p>ID: {{ $barberMan->id }}</p>
    <p>Barbershop: {{ $barberMan->barberShop->name }}</p>

    <a href="{{ route('barbermen.edit', $barberMan) }}">Edit</a>
    <a href="{{ route('barbermen.index') }}">Back</a>
</body>
</html>