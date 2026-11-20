<?php

namespace App\Http\Controllers;

use App\Models\BarberShop;
use App\Models\BarberShopsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarberShopsImagesController extends Controller
{
    /**
     * Display a listing of all barbershop images.
     */
    public function index()
    {
        $user = Auth::user();
        $query = BarberShopsImage::with('barberShop');

        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            $query->whereIn('barbershop_id', $shopIds);
        }

        $images = $query->latest()->get();

        return view('barbershop_images.index', compact('images'));
    }

    /**
     * Show the form to create a new barbershop image.
     */
    public function create()
    {
        $user = Auth::user();
        $barbershops = ($user && $user->isAdmin())
            ? BarberShop::all()
            : $user->barberShops;

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

        $user = Auth::user();
        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            if (!in_array((int)$validated['barbershop_id'], $shopIds)) {
                abort(403, 'Accès interdit. Vous ne pouvez ajouter des images qu’à votre salon.');
            }
        }

        $path = $request->file('image')->store('barbershop_images', 'public');

        BarberShopsImage::create([
            'path'          => $path,
            'is_primary'    => $request->boolean('is_primary'),
            'barbershop_id' => $validated['barbershop_id'],
        ]);

        return redirect()->route('shop-images.index')
                         ->with('success', 'Image uploadée avec succès!');
    }

    /**
     * Display the specified barbershop image.
     */
    public function show(BarberShopsImage $barberShopsImage)
    {
        $this->authorizeShopImage($barberShopsImage);

        $barberShopsImage->load('barberShop');

        return view('barbershop_images.show', compact('barberShopsImage'));
    }

    /**
     * Show the form to edit the specified barbershop image.
     */
    public function edit(BarberShopsImage $barberShopsImage)
    {
        $this->authorizeShopImage($barberShopsImage);

        $user = Auth::user();
        $barbershops = ($user && $user->isAdmin())
            ? BarberShop::all()
            : $user->barberShops;

        return view('barbershop_images.edit', compact('barberShopsImage', 'barbershops'));
    }

    /**
     * Update the specified barbershop image.
     */
    public function update(Request $request, BarberShopsImage $barberShopsImage)
    {
        $this->authorizeShopImage($barberShopsImage);

        $validated = $request->validate([
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_primary' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image from storage
            if ($barberShopsImage->path && Storage::disk('public')->exists($barberShopsImage->path)) {
                Storage::disk('public')->delete($barberShopsImage->path);
            }

            $barberShopsImage->path = $request->file('image')->store('barbershop_images', 'public');
        }

        $barberShopsImage->is_primary = $request->boolean('is_primary');
        $barberShopsImage->save();

        return redirect()->route('shop-images.index')
                         ->with('success', 'Image mise à jour avec succès!');
    }

    /**
     * Remove the specified barbershop image.
     */
    public function destroy(BarberShopsImage $barberShopsImage)
    {
        $this->authorizeShopImage($barberShopsImage);

        if ($barberShopsImage->path && Storage::disk('public')->exists($barberShopsImage->path)) {
            Storage::disk('public')->delete($barberShopsImage->path);
        }

        $barberShopsImage->delete();

        return redirect()->route('shop-images.index')
                         ->with('success', 'Image supprimée avec succès!');
    }

    private function authorizeShopImage(BarberShopsImage $image): void
    {
        $user = Auth::user();
        if ($user && $user->isBarberShop()) {
            $shopIds = $user->barberShopIds();
            if (!in_array((int)$image->barbershop_id, $shopIds)) {
                abort(403, 'Accès interdit. Cette image ne concerne pas votre salon.');
            }
        }
    }
}
