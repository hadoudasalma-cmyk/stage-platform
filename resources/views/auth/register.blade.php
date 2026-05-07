@extends('layouts.guest')
@section('title', 'Inscription — StageConnect')

@section('content')
<div x-data="{ role: '{{ old('role', 'student') }}' }">

    <h2 class="text-2xl font-bold text-slate-800 mb-1">Créer un compte</h2>
    <p class="text-slate-500 mb-6">Rejoignez la plateforme StageConnect</p>

    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    <!-- Choix du rôle -->
    <div class="grid grid-cols-2 gap-3 mb-6">
        <button type="button" @click="role = 'student'"
            :class="role === 'student' ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-slate-200 text-slate-600 hover:border-slate-300'"
            class="flex flex-col items-center gap-2 p-4 border-2 rounded-xl transition-all cursor-pointer">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
            <span class="text-sm font-semibold">Étudiant</span>
            <span class="text-xs text-center opacity-70">Je cherche un stage</span>
        </button>

        <button type="button" @click="role = 'company'"
            :class="role === 'company' ? 'border-primary-600 bg-primary-50 text-primary-700' : 'border-slate-200 text-slate-600 hover:border-slate-300'"
            class="flex flex-col items-center gap-2 p-4 border-2 rounded-xl transition-all cursor-pointer">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="text-sm font-semibold">Entreprise</span>
            <span class="text-xs text-center opacity-70">Je propose des stages</span>
        </button>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="role" :value="role">

        <!-- Nom -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">
                <span x-show="role === 'student'">Nom complet</span>
                <span x-show="role === 'company'">Nom de l'entreprise</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                :placeholder="role === 'student' ? 'Prénom Nom' : 'Nom de votre entreprise'">
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Adresse email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                placeholder="vous@exemple.com">
        </div>

        <!-- Mot de passe -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Mot de passe</label>
            <input type="password" name="password" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                placeholder="Minimum 8 caractères">
        </div>

        <!-- Confirmer -->
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
                placeholder="••••••••">
        </div>

        <button type="submit"
            class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors text-sm mt-2">
            Créer mon compte
        </button>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        Déjà un compte ?
        <a href="{{ route('login') }}" class="text-primary-600 font-medium hover:underline">Se connecter</a>
    </p>
</div>
@endsection
