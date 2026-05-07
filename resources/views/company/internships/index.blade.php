@extends('layouts.app')
@section('title', 'Mes offres')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Mes offres de stage</h1>
        <p class="text-gray-500 mt-1">{{ $internships->total() }} offre(s) publiée(s)</p>
    </div>
    <a href="{{ route('company.internships.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg text-sm transition flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nouvelle offre
    </a>
</div>

@if($internships->isEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
        </svg>
        <p class="text-gray-500 font-medium">Aucune offre publiée</p>
        <a href="{{ route('company.internships.create') }}" class="mt-3 inline-block bg-blue-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Publier une offre
        </a>
    </div>
@else
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="divide-y divide-gray-100">
            @foreach($internships as $internship)
            <div class="p-5 flex items-center gap-4 hover:bg-gray-50 transition">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-gray-800 truncate">{{ $internship->title }}</p>
                        <span @class([
                            'text-xs font-medium px-2 py-0.5 rounded-full flex-shrink-0',
                            'bg-green-100 text-green-700'  => $internship->status === 'active',
                            'bg-gray-100 text-gray-500'    => $internship->status === 'closed',
                            'bg-red-100 text-red-600'      => $internship->status === 'expired',
                        ])>{{ ucfirst($internship->status) }}</span>
                    </div>
                    <p class="text-sm text-gray-500 mt-0.5">
                        {{ $internship->field }} · {{ $internship->city }} · {{ $internship->duration }} mois
                    </p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="font-medium text-gray-700">{{ $internship->applications_count }}</span> candidature(s)
                </div>
                <div class="flex items-center gap-2 flex-shrink-0">
                    <a href="{{ route('company.internships.show', $internship) }}"
                        class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Voir">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <a href="{{ route('company.internships.edit', $internship) }}"
                        class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition" title="Modifier">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('company.internships.destroy', $internship) }}"
                        onsubmit="return confirm('Supprimer cette offre ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Supprimer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">{{ $internships->links() }}</div>
@endif

@endsection