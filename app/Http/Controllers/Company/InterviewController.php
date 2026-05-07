<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Planifier un entretien pour une candidature.
     */
    public function store(Request $request)
    {
        $request->validate([
            'application_id'  => ['required', 'exists:applications,id'],
            'interview_date'  => ['required', 'date', 'after:today'],
            'interview_time'  => ['required', 'date_format:H:i'],
            'location'        => ['nullable', 'string', 'max:255'],
            'type'            => ['required', 'in:in-person,online'],
            'notes'           => ['nullable', 'string'],
        ]);

        $application = Application::findOrFail($request->application_id);

        // Sécurité : vérifier que l'application appartient à l'entreprise
        $company = auth()->user()->company;
        if ($application->internship->company_id !== $company->id) {
            abort(403);
        }

        // Créer ou remplacer l'entretien
        Interview::updateOrCreate(
            ['application_id' => $application->id],
            [
                'interview_date' => $request->interview_date,
                'interview_time' => $request->interview_time,
                'location'       => $request->location,
                'type'           => $request->type,
                'status'         => 'scheduled',
                'notes'          => $request->notes,
            ]
        );

        // Mettre à jour le statut de la candidature
        $application->update(['status' => 'interview']);

        return back()->with('success', 'Entretien planifié avec succès !');
    }

    /**
     * Mettre à jour le statut d'un entretien.
     */
    public function update(Request $request, Interview $interview)
    {
        $company = auth()->user()->company;
        if ($interview->application->internship->company_id !== $company->id) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $interview->update(['status' => $request->status]);

        return back()->with('success', 'Entretien mis à jour.');
    }
}
