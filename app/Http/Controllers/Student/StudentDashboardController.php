<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;

        $stats = [
            'total_applications'    => $student->applications()->count(),
            'pending_applications'  => $student->applications()->where('status', 'pending')->count(),
            'accepted_applications' => $student->applications()->where('status', 'accepted')->count(),
            'interviews_scheduled'  => $student->applications()
                ->whereHas('interview', fn($q) => $q->where('status', 'scheduled'))
                ->count(),
        ];

        $recent_applications = $student->applications()
            ->with(['internship.company', 'interview'])
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('student', 'stats', 'recent_applications'));
    }
}
