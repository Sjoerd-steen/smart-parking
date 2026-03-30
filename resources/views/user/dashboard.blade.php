@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card !p-6 flex flex-col items-center justify-center text-center">
            <p class="text-sm text-gray-300 font-semibold mb-2 uppercase tracking-wide">Beschikbaar</p>
            <p class="text-4xl font-extrabold text-green-400">{{ $beschikbaar }}</p>
            <p class="text-xs text-gray-400 mt-2">parkeerplaatsen</p>
        </div>
        <div class="card !p-6 flex flex-col items-center justify-center text-center">
            <p class="text-sm text-gray-300 font-semibold mb-2 uppercase tracking-wide">Bezet</p>
            <p class="text-4xl font-extrabold text-red-500">{{ $bezet + $gereserveerd }}</p>
            <p class="text-xs text-gray-400 mt-2">parkeerplaatsen</p>
        </div>
        <div class="card !p-6 flex flex-col items-center justify-center text-center">
            <p class="text-sm text-gray-300 font-semibold mb-2 uppercase tracking-wide">Totaal</p>
            <p class="text-4xl font-extrabold text-blue-400">{{ $totalSpots }}</p>
            <p class="text-xs text-gray-400 mt-2">parkeerplaatsen</p>
        </div>
        <div class="card !p-6 flex flex-col items-center justify-center text-center">
            <p class="text-sm text-gray-300 font-semibold mb-2 uppercase tracking-wide">Bezettingsgraad</p>
            <p class="text-4xl font-extrabold text-purple-400">{{ $bezettingsgraad }}%</p>
            <p class="text-xs text-gray-400 mt-2">van alle plekken</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        {{-- PARKEERKAART (Left, takes 2 cols) --}}
        <div class="lg:col-span-2 card">
            <div class="flex items-center justify-between border-b border-gray-600 pb-4 mb-6">
                <h2 class="text-2xl font-bold text-white tracking-wide flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Parkeermap
                </h2>
                <a href="{{ route('user.reserve') }}" class="btn-primary !w-auto !mt-0 !py-2 text-sm uppercase">Nieuwe Reservering</a>
            </div>

            {{-- Bezettingsbalk --}}
            <div class="mb-8">
                <div class="flex justify-between text-sm font-bold text-gray-300 mb-2">
                    <span class="uppercase tracking-wider">Huidige Bezettingsgraad</span>
                    <span>{{ $bezettingsgraad }}%</span>
                </div>
                <div class="h-4 bg-gray-700 rounded-full overflow-hidden shadow-inner">
                    <div class="h-full rounded-full transition-all duration-1000 ease-out
          {{ $bezettingsgraad > 80 ? 'bg-red-500' : ($bezettingsgraad > 50 ? 'bg-yellow-500' : 'bg-green-500') }}"
                         style="width: {{ $bezettingsgraad }}%"></div>
                </div>
            </div>

            {{-- Grid van parkeerplekken --}}
            <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                @foreach($spots as $spot)
                    <div class="aspect-square rounded-xl flex flex-col items-center justify-center text-sm font-bold shadow-md transform hover:scale-105 transition-all duration-300 cursor-default relative overflow-hidden group
          {{ $spot->status === 'beschikbaar' ? 'bg-emerald-900/60 border-2 border-emerald-500/50 text-emerald-300 hover:border-emerald-400 hover:bg-emerald-800' :
             ($spot->status === 'gereserveerd' ? 'bg-amber-900/60 border-2 border-amber-500/50 text-amber-300 hover:border-amber-400 hover:bg-amber-800' :
             'bg-rose-900/60 border-2 border-rose-500/50 text-rose-300 hover:border-rose-400 hover:bg-rose-800') }}"
                         title="{{ $spot->name }} – {{ ucfirst($spot->status) }}">
                        <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <span class="text-2xl mb-1 drop-shadow-md">
                            @if($spot->status === 'beschikbaar')
                                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @elseif($spot->status === 'gereserveerd')
                                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @else
                                <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                            @endif
                        </span>
                        <span class="z-10 group-hover:drop-shadow-md">{{ Str::limit($spot->name, 4) }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Legenda --}}
            <div class="flex gap-6 mt-8 text-sm font-semibold text-gray-300 justify-center bg-gray-800 py-3 rounded-lg border border-gray-600/50 shadow-inner">
                <span class="flex items-center gap-2"><span class="w-4 h-4 bg-emerald-500 rounded-full shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span> Beschikbaar</span>
                <span class="flex items-center gap-2"><span class="w-4 h-4 bg-amber-500 rounded-full shadow-[0_0_8px_rgba(245,158,11,0.6)]"></span> Gereserveerd</span>
                <span class="flex items-center gap-2"><span class="w-4 h-4 bg-rose-500 rounded-full shadow-[0_0_8px_rgba(244,63,94,0.6)]"></span> Bezet</span>
            </div>

            <p class="text-xs text-gray-400 mt-6 text-center flex items-center justify-center gap-3">
                <span id="lastUpdate"></span>
                <button onclick="location.reload()" class="text-blue-400 font-semibold hover:text-blue-300 hover:underline transition-colors uppercase tracking-wider flex items-center gap-1 group">
                    <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Vernieuwen
                </button>
            </p>
        </div>

        {{-- SIDEBAR: Voertuigen & Reserveringen --}}
        <div class="space-y-8">
            {{-- MIJN VOERTUIGEN --}}
            <div class="card hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-bold text-white border-b border-gray-600 pb-3 mb-5 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h8M8 11h8m-8 4h8m-10 4h12l1-5H5l1 5z"></path></svg>
                    Mijn Voertuigen
                </h2>
                <div class="text-center py-4">
                    <p class="text-sm text-gray-300 mb-4">Beheer uw voertuigen op de aparte voertuigen pagina.</p>
                    <a href="{{ route('user.vehicles.index') }}" class="btn-primary inline-flex gap-2 !py-2 text-sm uppercase tracking-wider group">
                        Ga naar Voertuigen
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            {{-- MIJN RESERVERINGEN --}}
            <div class="card hover:shadow-lg transition-shadow">
                <h2 class="text-xl font-bold text-white border-b border-gray-600 pb-3 mb-5 uppercase tracking-wide flex items-center gap-2">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Recente Reserveringen
                </h2>
                @if($mijnReservaties->isEmpty())
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-gray-400 font-medium text-sm">Geen actieve reserveringen</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($mijnReservaties as $res)
                            <div class="p-4 bg-gray-800 rounded-xl border border-gray-600 shadow-md hover:border-blue-500 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="font-extrabold text-white text-lg">{{ $res->parkingSpot->name }}</p>
                                    <span class="bg-blue-900 text-blue-300 text-xs font-bold px-2 py-1 rounded-md">{{ $res->voertuig }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm text-gray-300 mb-2">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $res->datum->format('d-m-Y') }}
                                    </div>
                                    <div class="flex items-center gap-2 text-right justify-end">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($res->start_tijd)->format('H:i') }} - {{ \Carbon\Carbon::parse($res->eind_tijd)->format('H:i') }}
                                    </div>
                                </div>
                                @if($res->kenteken)
                                <p class="text-xs text-gray-400 font-mono tracking-widest bg-gray-900 inline-block px-2 py-1 rounded border border-gray-700 mt-1">
                                    {{ $res->kenteken }}
                                </p>
                                @endif
                                <div class="mt-3 pt-3 border-t border-gray-700 flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-400">Totaal:</span>
                                    <span class="text-lg font-bold text-green-400">€{{ number_format($res->totaal_prijs, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <a href="{{ route('user.reservations') }}" class="btn-primary !w-full !mt-6 text-sm uppercase tracking-wider bg-gray-700 hover:bg-gray-600 block">
                    Alle Reserveringen Bekijken
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('lastUpdate').textContent = 'BIJGEWERKT: ' + new Date().toLocaleTimeString('nl-NL');
    setTimeout(() => location.reload(), 30000);
</script>
@endsection

