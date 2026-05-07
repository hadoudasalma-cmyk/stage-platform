@extends('layouts.app')
@section('title', 'Mes candidatures')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mes candidatures</h1>
    <p class="text-gray-500 mt-1">{{ $applications->total() }} candidature(s) au total</p>
</div>

@if($applications->isEmpty())
    <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p class="text-gray-500 font-medium">Aucune candidature</p>
        <a href="{{ route('student.internships.index') }}" class="mt-3 inline-block bg-blue-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            Voir les offres
        </a>
    </div>
@else
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="divide-y divide-gray-100">
            @foreach($applications as $app)
            <div class="p-5 flex items-start gap-4 hover:bg-gray-50 transition">

                <!-- Company initial -->
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center text-blue-700 font-bold flex-shrink-0">
                    {{ strtoupper(substr($app->internship->company->company_name ?? 'S', 0, 1)) }}
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $app->internship->title }}</p>
                            <p class="text-sm text-gray-500 mt-0.5">
                                {{ $app->internship->company->company_name ?? '—' }}
                                · {{ $app->internship->city }}
                            </p>
                        </div>
                        <!-- Statut -->
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

                    <!-- Entretien info -->
                    @if($app->interview && $app->status === 'interview')
                    <div class="mt-2 p-2.5 bg-blue-50 rounded-lg text-xs text-blue-700 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Entretien le {{ \Carbon\Carbon::parse($app->interview->interview_date)->format('d/m/Y') }}
                        à {{ \Carbon\Carbon::parse($app->interview->interview_time)->format('H:i') }}
                        @if($app->interview->location) · {{ $app->interview->location }} @endif
                    </div>
                    @endif

                    <p class="text-xs text-gray-400 mt-2">
                        Postulé le {{ \Carbon\Carbon::parse($app->applied_at)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">{{ $applications->links() }}</div>
@endif

@endsection