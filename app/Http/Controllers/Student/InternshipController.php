<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipController extends Controller
{
    /**
     * Liste des offres avec filtres.
     */
    public function index(Request $request)
{
    $query = Internship::with('company')
        ->where('status', 'active');

    if ($request->filled('field')) {
        $query->where('field', 'like', '%' . $request->field . '%');
    }
    if ($request->filled('city')) {
        $query->where('city', 'like', '%' . $request->city . '%');
    }
    if ($request->filled('is_paid')) {
        $query->where('is_paid', $request->is_paid === 'yes');
    }
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    $internships = $query->latest()->paginate(10);

    return view('student.internships.index', compact('internships'));
}

    /**
     * Détail d'une offre.
     */
    public function show(Internship $internship)
    {
        $internship->load('company');

        $student = auth()->user()->student;

        // Vérifier si l'étudiant a déjà postulé
        $already_applied = $student->applications()
            ->where('internship_id', $internship->id)
            ->exists();

        return view('student.internships.show', compact('internship', 'already_applied'));
    }
}
