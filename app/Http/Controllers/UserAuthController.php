<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role !== 'user') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun admin tidak diperbolehkan login di portal user.',
                ])->withInput($request->only('email'));
            }

            $request->session()->regenerate();

            // Redirect based on whether they accepted terms
            if (!$user->terms_accepted) {
                return redirect()->route('user.dashboard')->with('show_terms', true);
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'nik' => 'required|string|max:30',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'nik' => $request->nik,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'terms_accepted' => false,
        ]);

        Auth::login($user);

        // Flash show_terms to show popup on registration login
        return redirect()->route('user.dashboard')->with('show_terms', true);
    }

    public function acceptTerms(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->terms_accepted = true;
            $user->save();
            
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('user.dashboard');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false], 401);
        }
        return redirect()->route('user.login');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone_number' => ['required', 'string', 'max:20'],
            'nik' => ['required', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->nik = $request->nik;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
