<?php

namespace App\Http\Controllers;

use App\Models\BarberShop;
use App\Models\Service;
use App\Models\ServicesImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index($id=0)
    {
        if(Auth::user()->isAdmin()){
            $services = Service::with(['barberShop', 'serviceImages', 'primaryImage'])
                        ->latest()
                        ->paginate(10);
        }
        if(Auth::user()->isBarberShop()){

            Auth::user()->barberShops()->findOrFail($id);
            $services = BarberShop::find($id)->services()->latest()
                        ->paginate(10);
             

        }
        // Load services with their barbershop and images
       

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $barbershops = BarberShop::all();
        return view('services.create', compact('barbershops'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'barbershop_id' => ['required', 'exists:barbershops,id'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:4096'],
        ]);

        $service = Service::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'barbershop_id' => $validated['barbershop_id'],
        ]);

        if ($request->hasFile('images')) {
            $isFirst = true;
            foreach ($request->file('images') as $file) {
                $path = $file->store('services', 'public');
                ServicesImage::create([
                    'path' => $path,
                    'is_primary' => $isFirst,
                    'service_id' => $service->id,
                ]);
                $isFirst = false;
            }
        }

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        $service->load(['barberShop', 'serviceImages', 'primaryImage']);
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $service->load(['serviceImages', 'barberShop']);
        $barbershops = BarberShop::all();
        return view('services.edit', compact('service', 'barbershops'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'barbershop_id' => ['required', 'exists:barbershops,id'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:4096'],
        ]);

        $service->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'barbershop_id' => $validated['barbershop_id'],
        ]);

        if ($request->hasFile('images')) {
            $hasPrimary = $service->serviceImages()->where('is_primary', true)->exists();
            $isFirst = !$hasPrimary;
            foreach ($request->file('images') as $file) {
                $path = $file->store('services', 'public');
                ServicesImage::create([
                    'path' => $path,
                    'is_primary' => $isFirst,
                    'service_id' => $service->id,
                ]);
                $isFirst = false;
            }
        }

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified service and its images from storage.
     */
    public function destroy(Service $service)
    {
        foreach ($service->serviceImages as $image) {
            if ($image->path && Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }
            $image->delete();
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }

    /**
     * Delete an individual service image.
     */
    public function deleteImage(ServicesImage $image)
    {
        $serviceId = $image->service_id;
        $wasPrimary = $image->is_primary;

        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }
        $image->delete();

        // If the deleted image was primary, set another image as primary if exists
        if ($wasPrimary) {
            $nextImage = ServicesImage::where('service_id', $serviceId)->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        return back()->with('success', 'Image removed successfully!');
    }

    /**
     * Set a specific image as the primary image for a service.
     */
    public function setPrimaryImage(ServicesImage $image)
    {
        ServicesImage::where('service_id', $image->service_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated successfully!');
    }
}
