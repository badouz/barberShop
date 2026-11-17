@extends("layout.primary")
@section("title") Upload Barbershop Image @endsection

@section("content")
<div class="col-md-8 mx-auto">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Upload Barbershop Image</h4>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('barbershop-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="barbershop_id" class="form-label">Barbershop</label>
                    <select name="barbershop_id" id="barbershop_id" class="form-control @error('barbershop_id') is-invalid @enderror" required>
                        <option value="">-- Select a barbershop --</option>
                        @foreach($barbershops as $shop)
                            <option value="{{ $shop->id }}" {{ old('barbershop_id') == $shop->id ? 'selected' : '' }}>
                                {{ $shop->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('barbershop_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*"
                           onchange="previewImage(event)"
                           required>
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
                               {{ old('is_primary') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_primary">
                            Set as Primary Image
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-gradient-primary">Upload</button>
                    <a href="{{ route('barbershop-images.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
