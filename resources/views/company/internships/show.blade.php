@extends('layouts.app')
@section('title', $internship->title)

@section('content')

<div class="mb-6">
    <a href="{{ route('company.internships.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour aux offres
    </a>
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $internship->title }}</h1>
            <p class="text-gray-500 mt-1">{{ $internship->field }} · {{ $internship->city }} · {{ $internship->duration }} mois</p>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <a href="{{ route('company.internships.edit', $internship) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier
            </a>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    <!-- Détail offre -->
    <div class="space-y-5">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 mb-4">Informations</h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Statut</span>
                    <span @class([
                        'font-medium px-2 py-0.5 rounded-full text-xs',
                        'bg-green-100 text-green-700' => $internship->status === 'active',
                        'bg-gray-100 text-gray-500'   => $internship->status === 'closed',
                        'bg-red-100 text-red-600'     => $internship->status === 'expired',
                    ])>{{ ucfirst($internship->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Domaine</span>
                    <span class="font-medium text-gray-700">{{ $internship->field }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Ville</span>
                    <span class="font-medium text-gray-700">{{ $internship->city }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Durée</span>
                    <span class="font-medium text-gray-700">{{ $internship->duration }} mois</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Début</span>
                    <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($internship->start_date)->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Rémunération</span>
                    <span class="font-medium {{ $internship->is_paid ? 'text-green-600' : 'text-gray-700' }}">
                        {{ $internship->is_paid ? ($internship->salary ? number_format($internship->salary, 0) . ' MAD' : 'Oui') : 'Non' }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Candidatures</span>
                    <span class="font-bold text-blue-600">{{ $internship->applications->count() }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 mb-3">Description</h2>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $internship->description }}</p>
        </div>

        @if($internship->requirements)
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <h2 class="font-semibold text-gray-800 mb-3">Profil recherché</h2>
            <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $internship->requirements }}</p>
        </div>
        @endif
    </div>

    <!-- Liste candidatures -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">Candidatures ({{ $internship->applications->count() }})</h2>
                <a href="{{ route('company.applications.index', ['internship_id' => $internship->id]) }}"
                    class="text-sm text-blue-600 hover:underline">Gérer tout</a>
            </div>

            @if($internship->applications->isEmpty())
                <div class="p-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Aucune candidature reçue</p>
                </div>
            @else
                <div class="divide-y divide-gray-100">
                    @foreach($internship->applications as $app)
                    <div class="px-6 py-4 flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold text-sm flex-shrink-0">
                            {{ strtoupper(substr($app->student->first_name ?? 'E', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 text-sm">
                                {{ $app->student->first_name }} {{ $app->student->last_name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $app->student->education_level ?? '' }}
                                {{ $app->student->field_of_study ? '— ' . $app->student->field_of_study : '' }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($app->student->cv_path)
                                <a href="{{ Storage::url($app->student->cv_path) }}" target="_blank"
                                    class="text-xs text-blue-600 hover:underline">CV</a>
                            @endif
                            <span @class([
                                'text-xs font-medium px-2.5 py-1 rounded-full',
                                'bg-amber-100 text-amber-700'  => $app->status === 'pending',
                                'bg-green-100 text-green-700'  => $app->status === 'accepted',
                                'bg-red-100 text-red-700'      => $app->status === 'rejected',
                                'bg-blue-100 text-blue-700'    => $app->status === 'interview',
                            ])>{{ ucfirst($app->status) }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection