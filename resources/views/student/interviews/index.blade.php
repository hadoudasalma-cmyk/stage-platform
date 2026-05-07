@extends('layouts.app')
@section('title', 'Mes entretiens')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mes entretiens</h1>
    <p class="text-gray-500 mt-1">Entretiens planifiés par les entreprises</p>
</div>

@if($interviews->isEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-gray-500 font-medium">Aucun entretien planifié</p>
        <p class="text-gray-400 text-sm mt-1">Les entreprises planifieront vos entretiens ici</p>
    </div>
@else
    <div class="space-y-4">
        @foreach($interviews as $interview)
        <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-start gap-5">

            <!-- Date block -->
            <div class="bg-blue-600 text-white rounded-xl p-4 text-center flex-shrink-0 min-w-16">
                <p class="text-2xl font-bold leading-none">{{ \Carbon\Carbon::parse($interview->interview_date)->format('d') }}</p>
                <p class="text-xs uppercase mt-1 opacity-80">{{ \Carbon\Carbon::parse($interview->interview_date)->translatedFormat('M') }}</p>
            </div>

            <!-- Info -->
            <div class="flex-1">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $interview->application->internship->title ?? '—' }}
                        </p>
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ $interview->application->internship->company->company_name ?? '—' }}
                        </p>
                    </div>
                    <span @class([
                        'text-xs font-semibold px-3 py-1 rounded-full',
                        'bg-blue-100 text-blue-700'   => $interview->status === 'scheduled',
                        'bg-green-100 text-green-700' => $interview->status === 'completed',
                        'bg-red-100 text-red-700'     => $interview->status === 'cancelled',
                    ])>
                        @switch($interview->status)
                            @case('scheduled')  📅 Planifié @break
                            @case('completed')  ✅ Terminé @break
                            @case('cancelled')  ❌ Annulé @break
                        @endswitch
                    </span>
                </div>

                <div class="flex flex-wrap gap-4 mt-3 text-sm text-gray-500">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ \Carbon\Carbon::parse($interview->interview_time)->format('H:i') }}
                    </span>
                    @if($interview->location)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $interview->location }}
                    </span>
                    @endif
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.82v6.36a1 1 0 01-1.447.894L15 14M3 8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/></svg>
                        {{ $interview->type === 'online' ? 'En ligne' : 'Présentiel' }}
                    </span>
                </div>

                @if($interview->notes)
                <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
                    <strong>Note :</strong> {{ $interview->notes }}
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection