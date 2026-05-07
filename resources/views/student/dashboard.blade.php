@extends('layouts.app')
@section('title', 'Tableau de bord — Étudiant')

@section('content')

<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Bonjour, {{ $student->first_name }} 👋</h1>
    <p class="text-slate-500 mt-1">Voici un résumé de vos candidatures</p>
</div>

<!-- Stats cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total candidatures</p>
        <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_applications'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">En attente</p>
        <p class="text-3xl font-bold text-amber-500 mt-2">{{ $stats['pending_applications'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Acceptées</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $stats['accepted_applications'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Entretiens</p>
        <p class="text-3xl font-bold text-primary-600 mt-2">{{ $stats['interviews_scheduled'] }}</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    <!-- Candidatures récentes -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Candidatures récentes</h2>
            <a href="{{ route('student.applications.index') }}" class="text-sm text-primary-600 hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recent_applications as $app)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center text-primary-700 font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($app->internship->company->company_name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $app->internship->title }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $app->internship->company->company_name ?? '—' }} · {{ $app->internship->city }}</p>
                    </div>
                    <span @class([
                        'text-xs font-medium px-2.5 py-1 rounded-full',
                        'bg-amber-100 text-amber-700'  => $app->status === 'pending',
                        'bg-green-100 text-green-700'  => $app->status === 'accepted',
                        'bg-red-100 text-red-700'      => $app->status === 'rejected',
                        'bg-blue-100 text-blue-700'    => $app->status === 'interview',
                    ])>
                        {{ ucfirst($app->status) }}
                    </span>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <p class="text-slate-500 text-sm">Aucune candidature pour l'instant</p>
                    <a href="{{ route('student.internships.index') }}" class="mt-3 inline-block text-sm text-primary-600 font-medium hover:underline">Voir les offres</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="font-semibold text-slate-800 mb-4">Actions rapides</h2>
            <div class="space-y-2">
                <a href="{{ route('student.internships.index') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 text-slate-600 hover:text-primary-700 transition group">
                    <div class="w-9 h-9 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200 transition">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <span class="text-sm font-medium">Chercher un stage</span>
                </a>
                <a href="{{ route('student.interviews.index') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-primary-50 text-slate-600 hover:text-primary-700 transition group">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-sm font-medium">Mes entretiens</span>
                </a>
            </div>
        </div>

        <!-- Profil completion -->
        @php
            $filled = collect([$student->phone, $student->city, $student->education_level, $student->field_of_study, $student->university, $student->cv_path])->filter()->count();
            $pct = round($filled / 6 * 100);
        @endphp
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-slate-800 text-sm">Profil complété</h2>
                <span class="text-sm font-bold text-primary-600">{{ $pct }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-2">
                <div class="bg-primary-600 h-2 rounded-full transition-all" style="width: {{ $pct }}%"></div>
            </div>
            @if($pct < 100)
                <p class="text-xs text-slate-500 mt-3">Complétez votre profil pour maximiser vos chances.</p>
            @endif
        </div>
    </div>
</div>

@endsection
