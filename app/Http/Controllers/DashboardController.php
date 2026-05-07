<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Admin Dashboard
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    // Student Dashboard
    public function studentDashboard()
    {
        $user = auth()->user();
        
        if (!$user || !$user->student) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        $student = $user->student;
        return view('student.dashboard', compact('student'));
    }

    // Company Dashboard
    public function companyDashboard()
    {
        $user = auth()->user();
        
        if (!$user || !$user->company) {
            return redirect()->route('login')->with('error', 'Please login first');
        }
        
        $company = $user->company;
        return view('company.dashboard', compact('company'));
    }
}