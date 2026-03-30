@extends('layouts.app')
@section('title', 'Mijn Voertuigen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-3xl font-bold text-white">🚗 Mijn Voertuigen</h2>
    <a href="{{ route('user.dashboard') }}" class="text-white hover:underline">&larr; Terug naar Dashboard</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    {{-- Toevoegen Formulier --}}
    <div class="card">
        <h3 class="text-xl font-bold mb-4">Voertuig Toevoegen</h3>
        <form method="POST" action="{{ route('user.vehicles.store') }}" class="flex flex-col gap-4">
            @csrf
            <div>
                <label class="form-label">Type Voertuig</label>
                <select name="type" class="form-input" required>
                    <option value="auto">Auto</option>
                    <option value="bus">Bus / Bestelwagen</option>
                    <option value="motor">Motor</option>
                    <option value="truck">Vrachtwagen</option>
                </select>
            </div>
            <div>
                <label class="form-label">Kenteken</label>
                <input type="text" name="license_plate" class="form-input uppercase" required placeholder="XX-123-Y">
            </div>
            <button type="submit" class="btn-primary w-full mt-2">➕ Opslaan</button>
        </form>
    </div>

    {{-- Lijst Voertuigen --}}
    <div class="card">
        <h3 class="text-xl font-bold mb-4">Mijn Geregistreerde Voertuigen</h3>
        @if($vehicles->isEmpty())
            <p class="text-gray-300 italic">Je hebt nog geen voertuigen toegevoegd.</p>
        @else
            <ul class="divide-y divide-gray-600">
                @foreach($vehicles as $vehicle)
                    <li class="py-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-700 p-3 rounded-xl border border-gray-600 shadow-inner">
                                @if(strtolower($vehicle->type) == 'auto')
                                    <span class="text-2xl" title="Auto">🚗</span>
                                @elseif(strtolower($vehicle->type) == 'motor')
                                    <span class="text-2xl" title="Motor">🏍️</span>
                                @elseif(in_array(strtolower($vehicle->type), ['truck', 'vrachtwagen']))
                                    <span class="text-2xl" title="Vrachtwagen">🚚</span>
                                @elseif(in_array(strtolower($vehicle->type), ['bus', 'bestelwagen']))
                                    <span class="text-2xl" title="Bus">🚐</span>
                                @else
                                    <span class="text-2xl" title="Anders">🚘</span>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-yellow-400 bg-yellow-900 px-3 py-1 rounded border border-yellow-600 inline-block mt-1 tracking-widest">{{ $vehicle->license_plate }}</h4>
                                <p class="text-sm text-gray-300 mt-1 capitalize">{{ $vehicle->type }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('user.vehicles.destroy', $vehicle) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Voertuig verwijderen?')" class="text-red-400 hover:text-red-300 text-sm font-semibold">❌ Verwijderen</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
