<?php

namespace App\Http\Controllers;

use App\Models\BarberShop;
use App\Models\BarberShopsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarberShopsImagesController extends Controller
{
    /**
     * Display a listing of all barbershop images.
     */
    public function index()
    {
        $images = BarberShopsImage::with('barberShop')->latest()->get();

        return view('barbershop_images.index', compact('images'));
    }

    /**
     * Show the form to create a new barbershop image.
     */
    public function create()
    {
        $barbershops = BarberShop::all();

        return view('barbershop_images.create', compact('barbershops'));
    }

    /**
     * Store a newly created barbershop image.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barbershop_id' => 'required|exists:barbershops,id',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_primary'    => 'boolean',
        ]);

        $path = $request->file('image')->store('barbershop_images', 'public');

        BarberShopsImage::create([
            'path'          => $path,
            'is_primary'    => $request->boolean('is_primary'),
            'barbershop_id' => $validated['barbershop_id'],
        ]);

        return redirect()->route('shop-images.index')
                         ->with('success', 'Image uploaded successfully!');
    }

    /**
     * Display the specified barbershop image.
     */
    public function show(BarberShopsImage $barberShopsImage)
    {
        $barberShopsImage->load('barberShop');

        return view('barbershop_images.show', compact('barberShopsImage'));
    }

    /**
     * Show the form to edit the specified barbershop image.
     */
    public function edit(BarberShopsImage $barberShopsImage)
    {
        $barbershops = BarberShop::all();

        return view('barbershop_images.edit', compact('barberShopsImage', 'barbershops'));
    }

    /**
     * Update the specified barbershop image.
     */
    public function update(Request $request, BarberShopsImage $barberShopsImage)
    {
        $validated = $request->validate([
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_primary' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image from storage
            Storage::disk('public')->delete($barberShopsImage->path);

            $barberShopsImage->path = $request->file('image')->store('barbershop_images', 'public');
        }

        $barberShopsImage->is_primary = $request->boolean('is_primary');
        $barberShopsImage->save();

        return redirect()->route('shop-images.index')
                         ->with('success', 'Image updated successfully!');
    }

    /**
     * Remove the specified barbershop image.
     */
    public function destroy(BarberShopsImage $barberShopsImage)
    {
        // Delete file from storage
        Storage::disk('public')->delete($barberShopsImage->path);

        $barberShopsImage->delete();

        return redirect()->route('shop-images.index')
                         ->with('success', 'Image deleted successfully!');
    }
}
