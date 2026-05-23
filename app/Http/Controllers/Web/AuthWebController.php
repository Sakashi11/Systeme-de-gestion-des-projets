<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthWebController extends Controller
{
    // Afficher page login
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isSuperAdmin()) {
                return redirect('/admin/dashboard');
            } elseif ($user->isChefProjet()) {
                return redirect('/chef/dashboard');
            } else {
                return redirect('/membre/dashboard');
            }
        }
        return view('auth.login');
    }

    // Traiter le login
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email incorrect.',
            ])->withInput();
        }

        // Première connexion → vérifier avec le code en clair
        if ($user->must_change_password && $request->password === $user->code) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect('/password/change')->with('warning', 'Veuillez changer votre mot de passe.');
        }

        // Connexions suivantes → vérifier avec mot de passe hashé
        if (\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->isSuperAdmin()) {
                return redirect('/admin/dashboard');
            } elseif ($user->isChefProjet()) {
                return redirect('/chef/dashboard');
            } else {
                return redirect('/membre/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->withInput();
    }
    // Afficher page register
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    // Traiter le register
    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8|confirmed',
            'profession' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'profession' => $request->profession,
            'role'       => 'membre',
        ]);

        Auth::login($user);

        return redirect('/membre/dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}