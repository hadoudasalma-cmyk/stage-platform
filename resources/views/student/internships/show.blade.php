@extends('layouts.app')
@section('title', $internship->title)

@section('content')

<!-- Back -->
<a href="{{ route('student.internships.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-6 transition">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Retour aux offres
</a>

<div class="grid lg:grid-cols-3 gap-6">

    <!-- Détail -->
    <div class="lg:col-span-2 space-y-5">

        <!-- Header -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-700 font-bold text-xl flex-shrink-0">
                    {{ strtoupper(substr($internship->company->company_name ?? 'S', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h1 class="text-xl font-bold text-gray-800">{{ $internship->title }}</h1>
                    <p class="text-gray-500 mt-0.5">{{ $internship->company->company_name ?? '—' }}</p>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="text-xs bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full font-medium">{{ $internship->field }}</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">📍 {{ $internship->city }}</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">⏱ {{ $internship->duration }} mois</span>
                        @if($internship->is_paid)
                            <span class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">
                                💰 {{ $internship->salary ? number_format($internship->salary, 0) . ' MAD' : 'Rémunéré' }}
                            </span>
                        @else
                            <span class="text-xs bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full">Non rémunéré</span>
                        @endif
                        @if($internship->start_date)
                            <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                                🗓 Début {{ \Carbon\Carbon::parse($internship->start_date)->format('d/m/Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-semibold text-gray-800 mb-3">Description du stage</h2>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $internship->description }}</p>
        </div>

        <!-- Requirements -->
        @if($internship->requirements)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-semibold text-gray-800 mb-3">Profil recherché</h2>
            <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $internship->requirements }}</p>
        </div>
        @endif

        <!-- À propos de l'entreprise -->
        @if($internship->company->description)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-semibold text-gray-800 mb-3">À propos de {{ $internship->company->company_name }}</h2>
            <p class="text-gray-600 text-sm leading-relaxed">{{ $internship->company->description }}</p>
            @if($internship->company->website)
                <a href="{{ $internship->company->website }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline mt-2">
                    🌐 {{ $internship->company->website }}
                </a>
            @endif
        </div>
        @endif
    </div>

    <!-- Sidebar candidature -->
    <div class="space-y-4">

        <!-- Formulaire candidature -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-6">

            @if($already_applied)
                <div class="text-center py-4">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-semibold text-gray-800">Candidature envoyée</p>
                    <p class="text-sm text-gray-500 mt-1">Vous avez déjà postulé à cette offre</p>
                    <a href="{{ route('student.applications.index') }}" class="mt-4 inline-block text-sm text-blue-600 hover:underline">
                        Voir mes candidatures
                    </a>
                </div>

            @else
                <h2 class="font-semibold text-gray-800 mb-4">Postuler à cette offre</h2>

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                        @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('student.applications.store') }}">
                    @csrf
                    <input type="hidden" name="internship_id" value="{{ $internship->id }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Lettre de motivation
                            <span class="text-gray-400 font-normal">(optionnel)</span>
                        </label>
                        <textarea name="cover_letter" rows="6"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                            placeholder="Présentez-vous et expliquez votre motivation...">{{ old('cover_letter') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition text-sm">
                        Envoyer ma candidature
                    </button>
                </form>
            @endif
        </div>

        <!-- Infos rapides -->
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h3 class="font-medium text-gray-700 mb-3 text-sm">Informations</h3>
            <div class="space-y-2.5">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Domaine</span>
                    <span class="font-medium text-gray-700">{{ $internship->field }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Durée</span>
                    <span class="font-medium text-gray-700">{{ $internship->duration }} mois</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Ville</span>
                    <span class="font-medium text-gray-700">{{ $internship->city }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Rémunération</span>
                    <span class="font-medium {{ $internship->is_paid ? 'text-green-600' : 'text-gray-700' }}">
                        {{ $internship->is_paid ? 'Oui' : 'Non' }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Statut</span>
                    <span class="font-medium text-green-600">Active</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection