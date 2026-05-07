@extends('layouts.app')
@section('title', 'Offres de stage')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Offres de stage</h1>
    <p class="text-gray-500 mt-1">{{ $internships->total() }} offres disponibles</p>
</div>

<!-- Filtres -->
<form method="GET" action="{{ route('student.internships.index') }}"
    class="bg-white rounded-xl border border-gray-200 p-4 mb-6 flex flex-wrap gap-3">

    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Titre, description..."
        class="flex-1 min-w-48 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

    <input type="text" name="field" value="{{ request('field') }}"
        placeholder="Domaine (ex: Informatique)"
        class="flex-1 min-w-40 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

    <input type="text" name="city" value="{{ request('city') }}"
        placeholder="Ville"
        class="w-36 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

    <select name="is_paid" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Rémunération</option>
        <option value="yes" {{ request('is_paid') === 'yes' ? 'selected' : '' }}>Rémunéré</option>
        <option value="no"  {{ request('is_paid') === 'no'  ? 'selected' : '' }}>Non rémunéré</option>
    </select>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg text-sm transition">
        Rechercher
    </button>

    @if(request()->hasAny(['search','field','city','is_paid']))
        <a href="{{ route('student.internships.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
            Réinitialiser
        </a>
    @endif
</form>

<!-- Liste des offres -->
@if($internships->isEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-500 font-medium">Aucune offre trouvée</p>
        <p class="text-gray-400 text-sm mt-1">Essayez d'autres filtres</p>
    </div>
@else
    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4 mb-6">
        @foreach($internships as $internship)
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-blue-300 hover:shadow-sm transition-all flex flex-col">

            <!-- Company -->
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-700 font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($internship->company->company_name ?? 'S', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $internship->company->company_name ?? '—' }}</p>
                    <p class="text-xs text-gray-500">{{ $internship->city }}</p>
                </div>
                @if($internship->is_paid)
                    <span class="ml-auto text-xs font-medium bg-green-100 text-green-700 px-2 py-0.5 rounded-full flex-shrink-0">Rémunéré</span>
                @endif
            </div>

            <!-- Title -->
            <h3 class="font-semibold text-gray-800 mb-2 line-clamp-2">{{ $internship->title }}</h3>
            <p class="text-sm text-gray-500 line-clamp-2 flex-1">{{ $internship->description }}</p>

            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mt-4">
                <span class="text-xs bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full">{{ $internship->field }}</span>
                <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $internship->duration }} mois</span>
                @if($internship->start_date)
                    <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">
                        {{ \Carbon\Carbon::parse($internship->start_date)->format('M Y') }}
                    </span>
                @endif
            </div>

            <!-- Action -->
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('student.internships.show', $internship) }}"
                    class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 rounded-lg transition">
                    Voir l'offre
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    {{ $internships->withQueryString()->links() }}
@endif

@endsection