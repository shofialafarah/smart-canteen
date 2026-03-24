<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'nama_warung' => ['required', 'string', 'max:255'],
        'foto_warung' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ]);

    // 1. Simpan Data User (Penjual)
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'penjual', // Otomatis jadi penjual
    ]);

    // 2. Upload Foto Warung
    $path = $request->file('foto_warung')->store('shops', 'public');

    // 3. Buat Data Warung Terhubung ke User tadi
    Shop::create([
        'user_id' => $user->id,
        'nama_warung' => $request->nama_warung,
        'foto_warung' => $path,
    ]);

    event(new Registered($user));

    Auth::login($user);

    // Redirect ke dashboard masing-masing
    return redirect(route('dashboard', absolute: false));
}
}
