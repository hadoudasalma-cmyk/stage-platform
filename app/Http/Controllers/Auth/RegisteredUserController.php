<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Company;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role'     => ['required', 'in:student,company'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Créer le profil selon le rôle
        if ($request->role === 'student') {
            Student::create([
                'user_id'    => $user->id,
                'first_name' => explode(' ', $request->name)[0],
                'last_name'  => explode(' ', $request->name, 2)[1] ?? '',
            ]);
        } elseif ($request->role === 'company') {
            Company::create([
                'user_id'      => $user->id,
                'company_name' => $request->name,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        $user = Auth::user();
        if ($user->isAdmin())   return redirect()->route('admin.dashboard');
        if ($user->isCompany()) return redirect()->route('company.dashboard');
        return redirect()->route('student.dashboard');
    }
}