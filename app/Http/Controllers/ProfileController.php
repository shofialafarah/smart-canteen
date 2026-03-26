<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Coba longgarkan validasi untuk testing
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'], // Naikkan ke 5MB
        ]);

        $user = $request->user();

        // Gunakan update() untuk memastikan fillable bekerja
        $user->fill([
            'name' => $request->name,
        ]);

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan dengan nama unik agar tidak bentrok
            $file = $request->file('foto_profil');
            $path = $file->store('profile-photos', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil kamu berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
