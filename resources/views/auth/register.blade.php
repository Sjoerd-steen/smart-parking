@extends('layouts.app')

@section('title', 'Registreren')

@section('content')
<div class="flex justify-center items-center py-8">
    <div class="card max-w-md w-full !p-8 animate-alert">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">Account aanmaken</h2>
            <p class="text-gray-600 dark:text-gray-300 text-sm">Vul uw gegevens in om lid te worden van SmartParking</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label" for="name">Gebruikersnaam</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="form-input pl-10 w-full"
                           placeholder="Jouw naam">
                </div>
            </div>

            <div>
                <label class="form-label" for="email">E-mailadres</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="form-input pl-10 w-full"
                           placeholder="naam@voorbeeld.nl">
                </div>
            </div>

            <div>
                <label class="form-label" for="password">Wachtwoord</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required minlength="6"
                           class="form-input pl-10 w-full"
                           placeholder="Minimaal 6 tekens">
                </div>
            </div>

            <div>
                <label class="form-label" for="password_confirmation">Herhaal wachtwoord</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-brand-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="form-input pl-10 w-full"
                           placeholder="••••••••">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn btn-primary w-full text-lg py-3 flex justify-center items-center gap-2 group">
                    Registreren
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center border-t border-gray-300 dark:border-gray-600 pt-6">
            <p class="text-gray-600 dark:text-gray-300 text-sm">
                Al een account? <a href="{{ route('login') }}" class="font-bold text-gray-900 dark:text-white hover:underline transition-all">Inloggen</a>
            </p>
        </div>
    </div>
</div>
@endsection
