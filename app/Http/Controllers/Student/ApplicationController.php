<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Internship;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Liste des candidatures de l'étudiant.
     */
    public function index()
    {
        $student = auth()->user()->student;

        $applications = $student->applications()
            ->with(['internship.company', 'interview'])
            ->latest('applied_at')
            ->paginate(10);

        return view('student.applications.index', compact('applications'));
    }

    /**
     * Postuler à une offre.
     */
    public function store(Request $request)
    {
        $request->validate([
            'internship_id' => ['required', 'exists:internships,id'],
            'cover_letter'  => ['nullable', 'string', 'max:3000'],
        ]);

        $student = auth()->user()->student;

        // Vérifier si déjà postulé
        $exists = Application::where('student_id', $student->id)
            ->where('internship_id', $request->internship_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        Application::create([
            'student_id'    => $student->id,
            'internship_id' => $request->internship_id,
            'cover_letter'  => $request->cover_letter,
            'status'        => 'pending',
        ]);

        return redirect()->route('student.applications.index')
            ->with('success', 'Candidature envoyée avec succès !');
    }
}
