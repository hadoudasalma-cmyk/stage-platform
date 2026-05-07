@extends('layouts.app')
@section('title', 'Candidatures reçues')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Candidatures reçues</h1>
    <p class="text-gray-500 mt-1">{{ $applications->total() }} candidature(s) au total</p>
</div>

<!-- Filtres -->
<form method="GET" action="{{ route('company.applications.index') }}"
    class="bg-white rounded-xl border border-gray-200 p-4 mb-6 flex flex-wrap gap-3">

    <select name="internship_id" class="flex-1 min-w-48 px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Toutes les offres</option>
        @foreach($internships as $internship)
            <option value="{{ $internship->id }}" {{ request('internship_id') == $internship->id ? 'selected' : '' }}>
                {{ $internship->title }}
            </option>
        @endforeach
    </select>

    <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Tous les statuts</option>
        <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
        <option value="accepted"  {{ request('status') === 'accepted'  ? 'selected' : '' }}>Acceptée</option>
        <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Refusée</option>
        <option value="interview" {{ request('status') === 'interview' ? 'selected' : '' }}>Entretien</option>
    </select>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg text-sm transition">
        Filtrer
    </button>
    @if(request()->hasAny(['internship_id', 'status']))
        <a href="{{ route('company.applications.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
            Réinitialiser
        </a>
    @endif
</form>

@if($applications->isEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p class="text-gray-500 font-medium">Aucune candidature reçue</p>
    </div>
@else
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="divide-y divide-gray-100">
            @foreach($applications as $app)
            <div class="p-5" x-data="{ open: false }">
                <div class="flex items-start gap-4">
                    <!-- Avatar -->
                    <div class="w-11 h-11 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold flex-shrink-0">
                        {{ strtoupper(substr($app->student->first_name ?? 'E', 0, 1)) }}
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $app->student->first_name ?? '' }} {{ $app->student->last_name ?? '' }}
                                </p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $app->internship->title ?? '—' }}
                                    · {{ \Carbon\Carbon::parse($app->applied_at)->format('d/m/Y') }}
                                </p>
                                @if($app->student->education_level || $app->student->field_of_study)
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $app->student->education_level }} {{ $app->student->field_of_study ? '— ' . $app->student->field_of_study : '' }}
                                        {{ $app->student->university ? '· ' . $app->student->university : '' }}
                                    </p>
                                @endif
                            </div>

                            <span @class([
                                'text-xs font-semibold px-3 py-1 rounded-full flex-shrink-0',
                                'bg-amber-100 text-amber-700'  => $app->status === 'pending',
                                'bg-green-100 text-green-700'  => $app->status === 'accepted',
                                'bg-red-100 text-red-700'      => $app->status === 'rejected',
                                'bg-blue-100 text-blue-700'    => $app->status === 'interview',
                            ])>
                                @switch($app->status)
                                    @case('pending')   ⏳ En attente @break
                                    @case('accepted')  ✅ Acceptée @break
                                    @case('rejected')  ❌ Refusée @break
                                    @case('interview') 📅 Entretien @break
                                @endswitch
                            </span>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-wrap items-center gap-2 mt-3">

                            <!-- CV -->
                            @if($app->student->cv_path)
                                <a href="{{ Storage::url($app->student->cv_path) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Voir CV
                                </a>
                            @endif

                            <!-- Lettre motivation -->
                            @if($app->cover_letter)
                                <button @click="open = !open"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-600 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Lettre de motivation
                                </button>
                            @endif

                            <!-- Changer statut -->
                            <form method="POST" action="{{ route('company.applications.update', $app) }}" class="flex gap-2">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <option value="pending"   {{ $app->status === 'pending'   ? 'selected' : '' }}>⏳ En attente</option>
                                    <option value="accepted"  {{ $app->status === 'accepted'  ? 'selected' : '' }}>✅ Accepter</option>
                                    <option value="rejected"  {{ $app->status === 'rejected'  ? 'selected' : '' }}>❌ Refuser</option>
                                    <option value="interview" {{ $app->status === 'interview' ? 'selected' : '' }}>📅 Entretien</option>
                                </select>
                            </form>

                            <!-- Planifier entretien -->
                            @if($app->status === 'accepted' || $app->status === 'interview')
                                <button @click="open = !open; $nextTick(() => document.getElementById('interview-form-{{ $app->id }}')?.scrollIntoView({behavior: 'smooth'}))"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Planifier entretien
                                </button>
                            @endif
                        </div>

                        <!-- Lettre motivation expandable -->
                        @if($app->cover_letter)
                        <div x-show="open" x-transition class="mt-3 p-4 bg-gray-50 rounded-lg border border-gray-200 text-sm text-gray-600 leading-relaxed" id="interview-form-{{ $app->id }}">
                            <p class="font-medium text-gray-700 mb-2">Lettre de motivation :</p>
                            <p class="whitespace-pre-line">{{ $app->cover_letter }}</p>
                        </div>
                        @endif

                        <!-- Formulaire entretien -->
                        @if($app->status === 'accepted' || $app->status === 'interview')
                        <div x-show="open" x-transition class="mt-3 p-4 bg-blue-50 rounded-lg border border-blue-200" id="interview-form-{{ $app->id }}">
                            <p class="font-semibold text-gray-800 mb-3 text-sm">Planifier un entretien</p>
                            @if($app->interview)
                                <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
                                    ✅ Entretien déjà planifié : {{ \Carbon\Carbon::parse($app->interview->interview_date)->format('d/m/Y') }}
                                    à {{ \Carbon\Carbon::parse($app->interview->interview_time)->format('H:i') }}
                                    @if($app->interview->location) · {{ $app->interview->location }} @endif
                                </div>
                            @endif
                            <form method="POST" action="{{ route('company.interviews.store') }}" class="grid md:grid-cols-2 gap-3">
                                @csrf
                                <input type="hidden" name="application_id" value="{{ $app->id }}">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Date *</label>
                                    <input type="date" name="interview_date" required
                                        value="{{ $app->interview?->interview_date?->format('Y-m-d') }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Heure *</label>
                                    <input type="time" name="interview_time" required
                                        value="{{ $app->interview?->interview_time ? \Carbon\Carbon::parse($app->interview->interview_time)->format('H:i') : '' }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Lieu / Lien</label>
                                    <input type="text" name="location"
                                        value="{{ $app->interview?->location }}"
                                        placeholder="ex: Bureau RH ou https://meet.google.com/..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                                    <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="in-person" {{ $app->interview?->type === 'in-person' ? 'selected' : '' }}>Présentiel</option>
                                        <option value="online" {{ $app->interview?->type === 'online' ? 'selected' : '' }}>En ligne</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Notes</label>
                                    <input type="text" name="notes"
                                        value="{{ $app->interview?->notes }}"
                                        placeholder="Instructions supplémentaires..."
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg text-sm transition">
                                        {{ $app->interview ? 'Modifier l\'entretien' : 'Planifier l\'entretien' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mt-4">{{ $applications->links() }}</div>
@endif

@endsection