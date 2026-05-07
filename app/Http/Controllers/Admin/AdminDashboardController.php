<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Internship;
use App\Models\Application;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students'     => User::where('role', 'student')->count(),
            'total_companies'    => User::where('role', 'company')->count(),
            'total_internships'  => Internship::count(),
            'active_internships' => Internship::where('status', 'active')->count(),
            'total_applications' => Application::count(),
            'pending_applications' => Application::where('status', 'pending')->count(),
        ];

        $recent_users = User::latest()->take(10)->get();
        $recent_internships = Internship::with('company')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_users', 'recent_internships'));
    }
}
