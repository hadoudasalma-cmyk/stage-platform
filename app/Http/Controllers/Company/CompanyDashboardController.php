<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class CompanyDashboardController extends Controller
{
    public function index()
{
    $company = auth()->user()->company;

    $stats = [
        'total_internships'    => $company->internships()->count(),
        'active_internships'   => $company->internships()->where('status', 'active')->count(),
        'total_applications'   => \App\Models\Application::whereHas('internship', fn($q) => $q->where('company_id', $company->id))->count(),
        'pending_applications' => \App\Models\Application::whereHas('internship', fn($q) => $q->where('company_id', $company->id))->where('status', 'pending')->count(),
        'interviews_scheduled' => \App\Models\Interview::whereHas('application.internship', fn($q) => $q->where('company_id', $company->id))->where('status', 'scheduled')->count(),
    ];

    $recent_applications = \App\Models\Application::whereHas('internship', fn($q) => $q->where('company_id', $company->id))
        ->with(['student.user', 'internship'])
        ->latest('applied_at')
        ->take(5)
        ->get();

    return view('company.dashboard', compact('company', 'stats', 'recent_applications'));
}
}
