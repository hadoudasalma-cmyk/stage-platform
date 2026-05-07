@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Dashboard Admin</h1>
    <p class="text-slate-500 mt-1">Vue globale de la plateforme</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Étudiants</p>
        <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_students'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Entreprises</p>
        <p class="text-3xl font-bold text-primary-600 mt-2">{{ $stats['total_companies'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Offres publiées</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $stats['total_internships'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Offres actives</p>
        <p class="text-3xl font-bold text-green-500 mt-2">{{ $stats['active_internships'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Candidatures</p>
        <p class="text-3xl font-bold text-blue-500 mt-2">{{ $stats['total_applications'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">En attente</p>
        <p class="text-3xl font-bold text-amber-500 mt-2">{{ $stats['pending_applications'] }}</p>
    </div>
</div>

<!-- Recent users -->
<div class="bg-white rounded-xl border border-slate-200">
    <div class="px-6 py-4 border-b border-slate-100">
        <h2 class="font-semibold text-slate-800">Derniers inscrits</h2>
    </div>
    <div class="divide-y divide-slate-100">
        @foreach($recent_users as $user)
            <div class="px-6 py-3.5 flex items-center gap-4">
                <div class="w-9 h-9 bg-primary-100 rounded-full flex items-center justify-center text-primary-700 font-semibold text-sm">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-800 truncate">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ $user->email }}</p>
                </div>
                <span @class([
                    'text-xs font-medium px-2.5 py-1 rounded-full',
                    'bg-blue-100 text-blue-700'   => $user->role === 'student',
                    'bg-green-100 text-green-700'  => $user->role === 'company',
                    'bg-red-100 text-red-700'      => $user->role === 'admin',
                ])>{{ ucfirst($user->role) }}</span>
                <p class="text-xs text-slate-400">{{ $user->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
</div>

@endsection
