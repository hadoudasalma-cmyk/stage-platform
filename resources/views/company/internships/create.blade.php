@extends('layouts.app')
@section('title', 'Publier une offre')

@section('content')

<div class="mb-6">
    <a href="{{ route('company.internships.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Retour
    </a>
    <h1 class="text-2xl font-bold text-gray-800">Publier une nouvelle offre</h1>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">

        @if($errors->any())
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('company.internships.store') }}" class="space-y-5">
            @csrf

            <div class="grid md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Titre du stage <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="ex: Développeur Web Full Stack">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Domaine <span class="text-red-500">*</span></label>
                    <input type="text" name="field" value="{{ old('field') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="ex: Informatique, Marketing...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ville <span class="text-red-500">*</span></label>
                    <input type="text" name="city" value="{{ old('city') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="ex: Casablanca">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Durée (mois) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration" value="{{ old('duration') }}" required min="1" max="24"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="ex: 3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Date de début <span class="text-red-500">*</span></label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Décrivez les missions du stagiaire...">{{ old('description') }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Profil recherché</label>
                    <textarea name="requirements" rows="3"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Compétences, niveau d'études, langues...">{{ old('requirements') }}</textarea>
                </div>

                <!-- Rémunération -->
                <div class="md:col-span-2" x-data="{ paid: {{ old('is_paid') ? 'true' : 'false' }} }">
                    <label class="flex items-center gap-2 cursor-pointer mb-3">
                        <input type="checkbox" name="is_paid" value="1" x-model="paid"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ old('is_paid') ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-700">Stage rémunéré</span>
                    </label>
                    <div x-show="paid" x-transition>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Salaire mensuel (MAD)</label>
                        <input type="number" name="salary" value="{{ old('salary') }}" min="0"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="ex: 2000">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-lg text-sm transition">
                    Publier l'offre
                </button>
                <a href="{{ route('company.internships.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded-lg text-sm hover:bg-gray-50 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@endsection