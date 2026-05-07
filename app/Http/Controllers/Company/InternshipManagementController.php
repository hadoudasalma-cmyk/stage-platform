<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use Illuminate\Http\Request;

class InternshipManagementController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $internships = $company->internships()->withCount('applications')->latest()->paginate(10);
        return view('company.internships.index', compact('internships'));
    }

    public function create()
    {
        return view('company.internships.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'field'        => ['required', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:255'],
            'duration'     => ['required', 'integer', 'min:1'],
            'start_date'   => ['required', 'date', 'after:today'],
            'requirements' => ['nullable', 'string'],
            'is_paid'      => ['boolean'],
            'salary'       => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['company_id'] = auth()->user()->company->id;
        $data['is_paid']    = $request->boolean('is_paid');

        Internship::create($data);

        return redirect()->route('company.internships.index')
            ->with('success', 'Offre publiée avec succès !');
    }

    public function show(Internship $internship)
    {
        $this->authorizeInternship($internship);
        $internship->load(['applications.student.user', 'applications.interview']);
        return view('company.internships.show', compact('internship'));
    }

    public function edit(Internship $internship)
    {
        $this->authorizeInternship($internship);
        return view('company.internships.edit', compact('internship'));
    }

    public function update(Request $request, Internship $internship)
    {
        $this->authorizeInternship($internship);

        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'field'        => ['required', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:255'],
            'duration'     => ['required', 'integer', 'min:1'],
            'start_date'   => ['required', 'date'],
            'requirements' => ['nullable', 'string'],
            'is_paid'      => ['boolean'],
            'salary'       => ['nullable', 'numeric', 'min:0'],
            'status'       => ['in:active,closed,expired'],
        ]);

        $data['is_paid'] = $request->boolean('is_paid');
        $internship->update($data);

        return redirect()->route('company.internships.index')
            ->with('success', 'Offre mise à jour.');
    }

    public function destroy(Internship $internship)
    {
        $this->authorizeInternship($internship);
        $internship->delete();
        return redirect()->route('company.internships.index')
            ->with('success', 'Offre supprimée.');
    }

    // Sécurité : l'entreprise ne peut modifier que ses propres offres
    private function authorizeInternship(Internship $internship)
    {
        if ($internship->company_id !== auth()->user()->company->id) {
            abort(403);
        }
    }
}
