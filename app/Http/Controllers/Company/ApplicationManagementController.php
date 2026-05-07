<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationManagementController extends Controller
{
    /**
     * Liste toutes les candidatures reçues pour les offres de l'entreprise.
     */
    public function index(Request $request)
    {
        $company = auth()->user()->company;

        $query = Application::whereHas('internship', fn($q) => $q->where('company_id', $company->id))
            ->with(['student.user', 'internship', 'interview']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('internship_id')) {
            $query->where('internship_id', $request->internship_id);
        }

        $applications = $query->latest('applied_at')->paginate(15);
        $internships  = $company->internships()->select('id', 'title')->get();

        return view('company.applications.index', compact('applications', 'internships'));
    }

    /**
     * Changer le statut d'une candidature (accepted / rejected / interview).
     */
    public function update(Request $request, Application $application)
    {
        // Vérifier que la candidature appartient à l'entreprise
        $company = auth()->user()->company;
        if ($application->internship->company_id !== $company->id) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected,interview'],
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Statut mis à jour.');
    }
}
