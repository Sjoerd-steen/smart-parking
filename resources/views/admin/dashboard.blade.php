@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold mb-2">Beheerderspaneel</h1>
            <p class="text-muted text-sm">Real-time inzicht in SmartParking prestaties</p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        @foreach([
          ['Gebruikers', $totalUsers, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>', 'blue'],
          ['Parkeerplaatsen', $totalSpots, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>', 'indigo'],
          ['Reserveringen', $totalReservations, '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>', 'purple'],
          ['Omzet', '€'.number_format($omzet,2), '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>', 'green'],
        ] as [$label, $value, $icon, $color])
            <div class="card hover:-translate-y-2 transition-transform duration-300">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-muted p-2 rounded-lg bg-gray-100 dark:bg-white/10">{!! $icon !!}</span>
                    <span class="badge-blue text-xs flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                        Live
                    </span>
                </div>
                <p class="text-3xl font-extrabold">{{ $value }}</p>
                <p class="text-sm font-medium text-muted mt-1 uppercase tracking-wide">{{ $label }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        {{-- Quick Links --}}
        <div class="card">
            <h3 class="font-bold mb-4 border-b border-gray-200 dark:border-white/20 pb-2">Snel Navigeren</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.spots.create') }}" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/10 rounded-lg transition-colors font-medium text-sm group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Parkeerplaats toevoegen
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/10 rounded-lg transition-colors font-medium text-sm group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Reserveringen beheren
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/5 hover:bg-gray-100 dark:hover:bg-white/10 rounded-lg transition-colors font-medium text-sm group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Gebruikers beheren
                </a>
            </div>
        </div>

        {{-- Bezettingsgraad --}}
        <div class="card">
            <h3 class="font-bold mb-4 border-b border-gray-200 dark:border-white/20 pb-2">Bezettingsgraad</h3>
            <div class="text-center py-6">
                <div class="text-6xl font-black {{ $bezettingsgraad > 80 ? 'text-red-500' : ($bezettingsgraad > 50 ? 'text-yellow-500' : 'text-green-500') }} drop-shadow-md">
                    {{ $bezettingsgraad }}%
                </div>
                <p class="text-muted text-sm mt-3 font-medium uppercase tracking-widest">van alle plaatsen bezet</p>
            </div>
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden mt-3">
                <div class="h-full rounded-full {{ $bezettingsgraad > 80 ? 'bg-red-500' : ($bezettingsgraad > 50 ? 'bg-yellow-400' : 'bg-green-600') }}"
                     style="width:{{ $bezettingsgraad }}%"></div>
            </div>
            <div class="flex justify-between text-xs text-muted mt-2">
                <span>{{ $beschikbaar }} beschikbaar</span>
                <span>{{ $totalSpots - $beschikbaar }} bezet</span>
            </div>
        </div>

        {{-- Actieve reserveringen --}}
        <div class="card">
            <h3 class="font-bold mb-4">🔴 Live Overzicht</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center p-3 bg-green-100 dark:bg-green-900/40 border border-green-200 dark:border-transparent rounded-lg">
                    <span class="text-sm text-green-800 dark:text-gray-300">Beschikbaar</span>
                    <span class="font-bold text-green-700 dark:text-green-300">{{ $beschikbaar }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-blue-100 dark:bg-blue-900/40 border border-blue-200 dark:border-transparent rounded-lg">
                    <span class="text-sm text-blue-800 dark:text-gray-300">Actieve res.</span>
                    <span class="font-bold text-blue-700 dark:text-blue-300">{{ $actief }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Recente Reserveringen --}}
    <div class="card">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-bold">📋 Recente Reserveringen</h3>
            <a href="{{ route('admin.reservations.index') }}" class="text-blue-600 text-sm hover:underline">Alles bekijken →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b border-gray-200 dark:border-gray-600">
                    <th class="pb-3 text-left text-muted font-medium">Gebruiker</th>
                    <th class="pb-3 text-left text-muted font-medium">Parkeerplaats</th>
                    <th class="pb-3 text-left text-muted font-medium">Datum</th>
                    <th class="pb-3 text-left text-muted font-medium">Prijs</th>
                    <th class="pb-3 text-left text-muted font-medium">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($recentReservations as $res)
                    <tr class="hover-row transition-colors">
                        <td class="py-3">{{ $res->user->name }}</td>
                        <td class="py-3">{{ $res->parkingSpot->name }}</td>
                        <td class="py-3 text-muted">{{ $res->datum->format('d-m-Y') }}</td>
                        <td class="py-3 font-semibold">€{{ number_format($res->totaal_prijs, 2) }}</td>
                        <td class="py-3">
              <span class="{{ $res->status === 'actief' ? 'badge-green' : ($res->status === 'geannuleerd' ? 'badge-red' : 'badge-blue') }}">
                {{ ucfirst($res->status) }}
              </span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
