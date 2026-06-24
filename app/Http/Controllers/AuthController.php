<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // ─── Login ──────────────────────────────────────────────────────

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Role-based redirect
            return match ($user->role) {
                'admin'   => redirect()->route('admin.dashboard'),
                'doctor'  => redirect()->route('doctor.dashboard'),
                'patient' => redirect()->route('patients.dashboard'),
                default   => redirect('/'),
            };
        }

        return back()->withErrors([
            'email' => '❌ Invalid email or password.',
        ])->onlyInput('email');
    }

    // ─── Register ───────────────────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'nullable|string|max:20',
            'role'                  => 'required|in:patient,doctor',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        return match ($user->role) {
            'doctor'  => redirect()->route('doctor.dashboard'),
            'patient' => redirect()->route('patients.dashboard'),
            default   => redirect('/'),
        };
    }

    // ─── Logout ─────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', '👋 You have been logged out.');
    }
}
