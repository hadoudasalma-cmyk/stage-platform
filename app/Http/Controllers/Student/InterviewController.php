<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;

class InterviewController extends Controller
{
    /**
     * Liste des entretiens planifiés pour l'étudiant.
     */
    public function index()
    {
        $student = auth()->user()->student;

        $interviews = $student->applications()
            ->with(['interview', 'internship.company'])
            ->whereHas('interview')
            ->get()
            ->pluck('interview')
            ->sortBy('interview_date');

        return view('student.interviews.index', compact('interviews'));
    }
}
