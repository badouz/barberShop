<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barbers</title>
</head>
<body>
    <h1>Barbers</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <a href="{{ route('barbermen.create') }}">Add barber</a>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Barbershop</th>
            <th>Actions</th>
        </tr>
        @foreach($barberMen as $barberMan)
            <tr>
                <td>{{ $barberMan->id }}</td>
                <td>{{ $barberMan->name }}</td>
                <td>{{ $barberMan->barberShop->name }}</td>
                <td>
                    <a href="{{ route('barbermen.show', $barberMan) }}">Show</a>
                    <a href="{{ route('barbermen.edit', $barberMan) }}">Edit</a>
                    <form action="{{ route('barbermen.destroy', $barberMan) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>