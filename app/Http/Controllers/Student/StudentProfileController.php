<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function edit()
    {
        $student = auth()->user()->student;
        return view('student.profile', compact('student'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name'      => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'city'            => ['nullable', 'string', 'max:100'],
            'date_of_birth'   => ['nullable', 'date'],
            'address'         => ['nullable', 'string', 'max:500'],
            'education_level' => ['nullable', 'string', 'max:50'],
            'field_of_study'  => ['nullable', 'string', 'max:255'],
            'university'      => ['nullable', 'string', 'max:255'],
            'cv'              => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
            'photo'           => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $student = auth()->user()->student;
        $data = $request->only([
            'first_name', 'last_name', 'phone', 'city',
            'date_of_birth', 'address', 'education_level',
            'field_of_study', 'university'
        ]);

        // Upload CV
        if ($request->hasFile('cv')) {
            if ($student->cv_path) {
                Storage::disk('public')->delete($student->cv_path);
            }
            $data['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        // Upload photo
        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('photos', 'public');
        }

        $student->update($data);

        return back()->with('success', 'Profil mis à jour avec succès !');
    }
}