<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function store(Request $request)
    {
        $isSiswa = $request->nisn ? true : false;

        $request->validate([
            'name' => 'required|string|max:255',
            'nisn' => $isSiswa ? 'required|unique:users,nisn' : 'nullable',
            'email' => !$isSiswa ? 'required|email|unique:users,email' : 'nullable',
        ]);

        $finalEmail = $isSiswa ? ($request->nisn . '@smartcanteen.com') : $request->email;

        User::create([
            'name' => $request->name,
            'nisn' => $request->nisn,
            'email' => $finalEmail,
            'role' => 'pembeli',
            'status_akun' => 'aktif',
            'balance' => $request->balance ?? 0,
            'password' => Hash::make('123123123'),
        ]);

        return back()->with('success', 'User pembeli berhasil ditambahkan!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->tipe_user_edit === 'siswa') {
            $user->update([
                'name' => $request->name,
                'nisn' => $request->identitas_update,
                'email' => $request->identitas_update . '@smartcanteen.com',
                'status_akun' => $request->status_akun,
                'balance' => $request->balance,
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->identitas_update,
                'status_akun' => $request->status_akun,
                'balance' => $request->balance,
            ]);
        }

        return back()->with('success', 'Data user berhasil diperbarui!');
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
                Storage::disk('supabase')->delete($user->foto_profil);
            }

            // Simpan dengan nama unik agar tidak bentrok
            $file = $request->file('foto_profil');
            $path = $file->store('profile-photos', 'supabase');
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
