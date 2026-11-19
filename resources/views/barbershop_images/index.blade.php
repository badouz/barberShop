@extends("layout.primary")
@section("title") Barbershop Images @endsection

@section("content")
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title">Barbershop Images</h4>
                <a href="{{ route('shop-images.create') }}" class="btn btn-gradient-primary btn-sm">
                    <i class="mdi mdi-plus"></i> Add Image
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($images->isEmpty())
                <p class="text-muted text-center py-4">No images found. <a href="{{ route('shop-images.create') }}">Upload the first one!</a></p>
            @else
                <div class="row">
                    @foreach($images as $image)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img
                                    src="{{ Storage::disk('public')->exists($image->path) ? asset('storage/' . $image->path) : asset('assets/images/dashboard/img_placeholder.jpg') }}"
                                    class="card-img-top"
                                    alt="Barbershop Image"
                                    style="height: 180px; object-fit: cover;"
                                >
                                <div class="card-body p-2">
                                    <p class="mb-1 small fw-bold">{{ $image->barberShop->name ?? 'N/A' }}</p>
                                    @if($image->is_primary)
                                        <span class="badge bg-gradient-success">Primary</span>
                                    @else
                                        <span class="badge bg-secondary">Secondary</span>
                                    @endif
                                </div>
                                <div class="card-footer p-2 d-flex gap-1">
                                    <a href="{{ route('shop-images.show', $image->id) }}" class="btn btn-sm btn-outline-info flex-fill">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <a href="{{ route('shop-images.edit', $image->id) }}" class="btn btn-sm btn-outline-warning flex-fill">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('shop-images.destroy', $image->id) }}" method="POST"
                                          onsubmit="return confirm('Delete this image?')" class="flex-fill">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
