<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    // Afficher le formulaire
    public function showChangeForm()
    {
        return view('password.change');
    }

    // Traiter le changement
    public function change(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password             = Hash::make($request->password);
        $user->must_change_password = false;
        $user->save();

        // Rediriger selon le rôle
        if ($user->isSuperAdmin()) {
            return redirect('/admin/dashboard')->with('success', 'Mot de passe changé avec succès !');
        } elseif ($user->isChefProjet()) {
            return redirect('/chef/dashboard')->with('success', 'Mot de passe changé avec succès !');
        } else {
            return redirect('/membre/dashboard')->with('success', 'Mot de passe changé avec succès !');
        }
    }
}