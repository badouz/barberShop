<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private function authorizeAdmin(): void
    {
        $user = Auth::user();
        if (!$user || !$user->isAdmin()) {
            abort(403, 'Accès réservé uniquement aux administrateurs.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizeAdmin();

        $users = User::latest()->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAdmin();

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
            'address'  => 'nullable|string|max:255',
            'zip'      => 'nullable|string|max:20',
            'role'     => 'nullable|string|in:ADMIN,BARBERSHOP',
        ]);

        $validated['role'] = $validated['role'] ?? User::BARBER_SHOP;

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        return view('auth.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        return view('auth.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'city'     => 'nullable|string|max:100',
            'address'  => 'nullable|string|max:255',
            'zip'      => 'nullable|string|max:20',
            'role'     => 'nullable|string|in:ADMIN,BARBERSHOP',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès!');
    }
}
