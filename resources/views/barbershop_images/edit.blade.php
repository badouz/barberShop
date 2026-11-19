@extends("layout.primary")
@section("title") Edit Barbershop Image @endsection

@section("content")
<div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Edit Barbershop Image</h4>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('shop-images.update', $barberShopsImage->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="form-label">Barbershop</label>
                    <input type="text" class="form-control" value="{{ $barberShopsImage->barberShop->name ?? 'N/A' }}" disabled>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Current Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $barberShopsImage->path) }}"
                             alt="Current Image"
                             style="max-height: 200px;"
                             class="img-thumbnail">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="image" class="form-label">Replace Image <span class="text-muted small">(optional)</span></label>
                    <input type="file" name="image" id="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-2">
                        <img id="preview" src="#" alt="Preview" style="max-height: 200px; display: none;" class="img-thumbnail">
                    </div>
                </div>

                <div class="form-group mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_primary" id="is_primary" value="1"
                               {{ $barberShopsImage->is_primary ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_primary">
                            Set as Primary Image
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient-warning">Update</button>
                    <a href="{{ route('shop-images.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.style.display = 'block';
    }
</script>
@endsection
