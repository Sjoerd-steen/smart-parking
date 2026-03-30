@extends('layouts.app')
@section('title', 'Mijn Profiel')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        <h2 class="text-3xl font-extrabold text-white tracking-tight">Mijn Profiel</h2>
    </div>
    <a href="{{ route('user.dashboard') }}" class="text-white bg-white/10 hover:bg-white/20 px-4 py-2 rounded-lg font-semibold transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Terug
    </a>
</div>

<div class="card max-w-2xl mx-auto border-t-4 border-blue-500 shadow-xl">
    <form method="POST" action="{{ route('user.profile.update') }}" class="flex flex-col gap-6">
        @csrf
        @method('PUT')
        
        <div>
            <label class="form-label" for="name">Naam</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="form-input" placeholder="Uw volledige naam">
        </div>
        
        <div>
            <label class="form-label" for="email">E-mailadres</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="form-input" placeholder="naam@voorbeeld.nl">
        </div>
        
        <div class="relative py-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-600"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-3 bg-[#3b4b6b] text-lg font-bold text-gray-300">Wachtwoord Wijzigen (Optioneel)</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="form-label" for="password">Nieuw Wachtwoord</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Nieuw wachtwoord">
            </div>
            
            <div>
                <label class="form-label" for="password_confirmation">Bevestig Wachtwoord</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Herhaal wachtwoord">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-600 mt-2">
            <button type="submit" class="btn-primary w-full shadow-lg flex items-center justify-center gap-2 py-3 text-lg group">
                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                Profiel Opslaan
            </button>
        </div>
    </form>
</div>
@endsection