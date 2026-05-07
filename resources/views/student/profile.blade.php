@extends('layouts.app')
@section('title', 'Mon profil')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mon profil</h1>
    <p class="text-gray-500 mt-1">Complétez votre profil pour maximiser vos chances</p>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="grid lg:grid-cols-3 gap-6">

    <!-- Sidebar profil -->
    <div class="space-y-4">

        <!-- Photo + nom -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-2xl mx-auto mb-3">
                {{ strtoupper(substr($student->first_name ?? auth()->user()->name, 0, 1)) }}
            </div>
            <p class="font-semibold text-gray-800">{{ $student->first_name }} {{ $student->last_name }}</p>
            <p class="text-sm text-gray-500 mt-0.5">{{ $student->field_of_study ?? 'Domaine non renseigné' }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $student->university ?? 'Université non renseignée' }}</p>

            <!-- Progression -->
            @php
                $fields = [$student->phone, $student->city, $student->education_level, $student->field_of_study, $student->university, $student->cv_path];
                $filled = collect($fields)->filter()->count();
                $pct = round($filled / count($fields) * 100);
            @endphp
            <div class="mt-4">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>Profil complété</span>
                    <span class="font-semibold text-blue-600">{{ $pct }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        </div>

        <!-- CV actuel -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-semibold text-gray-800 mb-3 text-sm">CV actuel</h3>
            @if($student->cv_path)
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                    <svg class="w-8 h-8 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-700 truncate">CV uploadé ✓</p>
                        <a href="{{ Storage::url($student->cv_path) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Voir le CV</a>
                    </div>
                </div>
            @else
                <div class="p-3 bg-amber-50 rounded-lg border border-amber-200 text-center">
                    <p class="text-xs text-amber-700">⚠️ Aucun CV uploadé</p>
                    <p class="text-xs text-gray-500 mt-1">Ajoutez votre CV ci-contre</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Formulaire principal -->
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Informations personnelles -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Informations personnelles</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                            placeholder="ex: 0612345678"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Ville</label>
                        <input type="text" name="city" value="{{ old('city', $student->city) }}"
                            placeholder="ex: Casablanca"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Date de naissance</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Adresse</label>
                        <input type="text" name="address" value="{{ old('address', $student->address) }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Formation -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Formation académique</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Niveau d'études</label>
                        <select name="education_level"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Sélectionner...</option>
                            @foreach(['Bac', 'Bac+1', 'Bac+2', 'Bac+3', 'Bac+4', 'Bac+5', 'Doctorat'] as $level)
                                <option value="{{ $level }}" {{ old('education_level', $student->education_level) === $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Domaine d'études</label>
                        <input type="text" name="field_of_study" value="{{ old('field_of_study', $student->field_of_study) }}"
                            placeholder="ex: Génie Informatique"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Université / École</label>
                        <input type="text" name="university" value="{{ old('university', $student->university) }}"
                            placeholder="ex: Université Mohammed V"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Documents</h2>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            CV <span class="text-gray-400 font-normal">(PDF, max 2MB)</span>
                        </label>
                        <input type="file" name="cv" accept=".pdf"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if($student->cv_path)
                            <p class="text-xs text-green-600 mt-1">✓ CV déjà uploadé — uploader un nouveau pour remplacer</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Photo <span class="text-gray-400 font-normal">(JPG/PNG, max 1MB)</span>
                        </label>
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

@endsection