@extends('layouts.app')

@section('title', 'Inloggen')

@section('content')
<div class="flex justify-center items-center py-12">
    <div class="card max-w-md w-full !p-8 animate-alert">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-white tracking-tight mb-2">Welkom terug</h2>
            <p class="text-gray-300 text-sm">Log in op uw SmartParking account</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
            @csrf
            <div>
                <label class="form-label" for="email">E-mailadres</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="form-input pl-10 w-full"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between pb-2">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="h-4 w-4 text-[#3b5998] focus:ring-[#3b5998] border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-300">
                        Onthoud mij
                    </label>
                </div>
                <a href="#" class="text-sm font-medium text-gray-300 hover:text-white transition-colors duration-200">Wachtwoord vergeten?</a>
            </div>

            <button type="submit" class="btn-primary w-full text-lg py-3 flex justify-center items-center gap-2 group">
                Inloggen
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-gray-600 pt-6">
            <p class="text-gray-300 text-sm">
                Nog geen account? <a href="{{ route('register') }}" class="font-bold text-white hover:underline transition-all">Registreer nu</a>
            </p>
        </div>
    </div>
</div>
@endsection
