<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription avec choix du rôle.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Traiter l'inscription et créer le profil selon le rôle.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:student,company'],
        ]);

        // Créer le user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // Créer le profil selon le rôle
        if ($user->isStudent()) {
            Student::create([
                'user_id'    => $user->id,
                'first_name' => explode(' ', $request->name)[0],
                'last_name'  => explode(' ', $request->name)[1] ?? '',
            ]);
        } elseif ($user->isCompany()) {
            Company::create([
                'user_id'      => $user->id,
                'company_name' => $request->name,
            ]);
        }

        Auth::login($user);

        // Redirect selon le rôle
        return $this->redirectByRole($user);
    }

    private function redirectByRole($user)
    {
        if ($user->isAdmin())   return redirect()->route('admin.dashboard');
        if ($user->isCompany()) return redirect()->route('company.dashboard');
        return redirect()->route('student.dashboard');
    }
}
