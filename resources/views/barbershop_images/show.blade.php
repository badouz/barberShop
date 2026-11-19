@extends("layout.primary")
@section("title") Image Details @endsection

@section("content")
<div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title">Image Details</h4>
                <a href="{{ route('shop-images.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Back
                </a>
            </div>

            <div class="text-center mb-4">
                <img src="{{ asset('storage/' . $barberShopsImage->path) }}"
                     alt="Barbershop Image"
                     class="img-fluid rounded shadow"
                     style="max-height: 350px;">
            </div>

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th style="width: 30%">ID</th>
                        <td>{{ $barberShopsImage->id }}</td>
                    </tr>
                    <tr>
                        <th>Barbershop</th>
                        <td>{{ $barberShopsImage->barberShop->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Primary</th>
                        <td>
                            @if($barberShopsImage->is_primary)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Path</th>
                        <td><code>{{ $barberShopsImage->path }}</code></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $barberShopsImage->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex gap-2 mt-3">
                <a href="{{ route('shop-images.edit', $barberShopsImage->id) }}"
                   class="btn btn-gradient-warning">
                    <i class="mdi mdi-pencil"></i> Edit
                </a>
                <form action="{{ route('shop-images.destroy', $barberShopsImage->id) }}" method="POST"
                      onsubmit="return confirm('Delete this image?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-gradient-danger">
                        <i class="mdi mdi-delete"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
