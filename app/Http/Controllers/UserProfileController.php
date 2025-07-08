<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat' => 'required|string|max:500',
            'no_hp' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/',
        ], [
            'alamat.required' => 'Alamat harus diisi',
            'alamat.max' => 'Alamat maksimal 500 karakter',
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.min' => 'Nomor HP minimal 10 karakter',
            'no_hp.max' => 'Nomor HP maksimal 15 karakter',
            'no_hp.regex' => 'Format nomor HP tidak valid'
        ]);

        User::where('id', $user->id)->update([
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }
}