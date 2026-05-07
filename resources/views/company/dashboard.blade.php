@extends('layouts.app')
@section('title', 'Tableau de bord — Entreprise')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Bonjour, {{ $company->company_name }} 👋</h1>
    <p class="text-gray-500 mt-1">Gérez vos offres et candidatures</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Offres publiées</p>
        <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['total_internships'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Offres actives</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $stats['active_internships'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Candidatures</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['total_applications'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">En attente</p>
        <p class="text-3xl font-bold text-amber-500 mt-2">{{ $stats['pending_applications'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Entretiens</p>
        <p class="text-3xl font-bold text-blue-500 mt-2">{{ $stats['interviews_scheduled'] }}</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    <!-- Candidatures récentes -->
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Dernières candidatures</h2>
            <a href="{{ route('company.applications.index') }}" class="text-sm text-blue-600 hover:underline">Voir tout</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recent_applications as $app)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold text-sm flex-shrink-0">
                        {{ strtoupper(substr($app->student->first_name ?? 'E', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">
                            {{ $app->student->first_name ?? '' }} {{ $app->student->last_name ?? '' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">{{ $app->internship->title ?? '—' }}</p>
                    </div>
                    <span @class([
                        'text-xs font-medium px-2.5 py-1 rounded-full',
                        'bg-amber-100 text-amber-700'  => $app->status === 'pending',
                        'bg-green-100 text-green-700'  => $app->status === 'accepted',
                        'bg-red-100 text-red-700'      => $app->status === 'rejected',
                        'bg-blue-100 text-blue-700'    => $app->status === 'interview',
                    ])>{{ ucfirst($app->status) }}</span>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Aucune candidature reçue</p>
                    <a href="{{ route('company.internships.create') }}" class="mt-3 inline-block text-sm text-blue-600 font-medium hover:underline">Publier une offre</a>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="space-y-4">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="font-semibold text-gray-800 mb-4">Actions rapides</h2>
            <div class="space-y-2">
                <a href="{{ route('company.internships.create') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-700 transition group">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Publier une offre</span>
                </a>
                <a href="{{ route('company.internships.index') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-700 transition group">
                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Mes offres</span>
                </a>
                <a href="{{ route('company.applications.index') }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-700 transition group">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Voir candidatures</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection