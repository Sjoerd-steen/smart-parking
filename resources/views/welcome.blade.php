<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Parking - Slim parkeren zonder stress</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-text {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased leading-relaxed" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- 1. Header -->
    <header class="fixed w-full top-0 z-50 transition-all duration-300" 
            :class="scrolled ? 'bg-white/90 backdrop-blur-md shadow-sm py-3' : 'bg-transparent py-5'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                <span class="text-xl font-bold tracking-tight text-slate-900">Smart Parking</span>
            </div>
            
            <nav class="hidden md:flex space-x-8">
                <a href="#home" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Home</a>
                <a href="#over-ons" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Over Ons</a>
                <a href="#tarieven" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Tarieven</a>
                <a href="#locaties" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Locaties</a>
                <a href="#reviews" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Reviews</a>
            </nav>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600 transition hidden sm:block">Inloggen</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all">
                                Registreer Nu
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- 2. Hero Sectie -->
    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-slate-100 -z-10"></div>
        <div class="absolute inset-y-0 right-0 w-1/2 bg-blue-600/5 rounded-l-full blur-3xl -z-10 transform translate-x-1/3"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                <div class="lg:col-span-6 text-center lg:text-left mb-16 lg:mb-0">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                        Slim parkeren <br>
                        <span class="bg-gradient-to-r from-blue-600 to-indigo-600 text-transparent bg-clip-text">zonder stress</span>
                    </h1>
                    <p class="text-lg sm:text-xl text-slate-600 mb-10 max-w-2xl mx-auto lg:mx-0">
                        Vind, reserveer en betaal eenvoudig je parkeerplek via Smart Parking. Geen gedoe meer met zoeken of kleingeld.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') ?? '#' }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-blue-600 rounded-full shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all duration-300">
                            Registreer Nu
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                        <a href="#hoe-het-werkt" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-slate-700 bg-white border border-slate-200 rounded-full shadow-sm hover:bg-slate-50 hover:-translate-y-0.5 transition-all duration-300">
                            Hoe het werkt
                        </a>
                    </div>
                </div>
                <div class="lg:col-span-6 relative">
                    <div class="relative rounded-2xl bg-slate-900 shadow-2xl overflow-hidden aspect-[4/3] transform hover:scale-[1.02] transition-transform duration-500">
                        <!-- Mockup placeholder -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-slate-800 to-slate-900 flex items-center justify-center">
                            <svg class="w-32 h-32 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Over Smart Parking -->
    <section id="over-ons" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-6">De parkeeroplossing van de toekomst</h2>
                <p class="text-lg text-slate-600">
                    Smart Parking is ontstaan vanuit een simpele frustratie: het eindeloze zoeken naar een parkeerplek, tijdverlies in druk verkeer en het gedoe met betalingen. Ons systeem brengt vraag en aanbod real-time bij elkaar.
                </p>
            </div>
            
            <div class="bg-slate-50 rounded-3xl p-8 sm:p-12 mb-12">
                <h3 class="text-xl font-bold text-slate-900 mb-6 text-center">Het Team</h3>
                <p class="text-slate-600 text-center max-w-2xl mx-auto">
                    Smart Parking is met passie ontwikkeld door <strong>Sjoerd, Adem, Salim en Mokhless</strong> met als doel parkeren slimmer, sneller en eenvoudiger te maken voor iedereen.
                </p>
            </div>
        </div>
    </section>

    <!-- 4. Hoe Het Werkt -->
    <section id="hoe-het-werkt" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Hoe werkt het?</h2>
                <p class="text-lg text-slate-600">Automatiseer je parkeerervaring in 4 simpele stappen.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">1. Zoek locatie</h3>
                    <p class="text-slate-600">Vind eenvoudig een beschikbare parkeerplaats in de buurt of op je bestemming.</p>
                </div>
                <!-- Step 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">2. Reserveer direct</h3>
                    <p class="text-slate-600">Claim je plek vooraf. Zo ben je altijd gegarandeerd van een parkeerplaats.</p>
                </div>
                <!-- Step 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">3. Navigeer</h3>
                    <p class="text-slate-600">Rijd zonder omwegen naar je gereserveerde parkeerplek via de app.</p>
                </div>
                <!-- Step 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">4. Betaal veilig</h3>
                    <p class="text-slate-600">Afrekenen gebeurt automatisch of via de app, zonder gedoe met contant geld.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Tarieven -->
    <section id="tarieven" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Transparante tarieven</h2>
                <p class="text-lg text-slate-600">Kies de optie die bij jouw parkeerbehoefte past.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Plan 1 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Basis Parking</h3>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-4xl font-extrabold text-slate-900">€2</span>
                        <span class="text-slate-500">/u</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-slate-600"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Live beschikbaarheid</li>
                        <li class="flex items-center text-slate-600"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Standaard locaties</li>
                        <li class="flex items-center text-slate-600"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Betaal achteraf</li>
                    </ul>
                    <a href="{{ route('register') ?? '#' }}" class="block w-full py-3 px-4 bg-white border-2 border-slate-200 text-slate-700 font-bold text-center rounded-xl hover:bg-slate-50 transition">Kies Basis</a>
                </div>
                
                <!-- Plan 2 (Popular) -->
                <div class="bg-blue-600 p-8 rounded-3xl shadow-2xl transform md:-translate-y-4 relative">
                    <div class="absolute top-0 right-8 transform -translate-y-1/2">
                        <span class="bg-gradient-to-r from-amber-400 to-amber-500 text-white text-xs font-bold uppercase tracking-wider py-1 px-3 rounded-full">Meest Gekozen</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Centrum Parking</h3>
                    <div class="flex items-baseline gap-1 mb-6 text-white">
                        <span class="text-4xl font-extrabold">€4</span>
                        <span class="text-blue-200">/u</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-blue-100"><svg class="w-5 h-5 text-blue-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Live beschikbaarheid</li>
                        <li class="flex items-center text-blue-100"><svg class="w-5 h-5 text-blue-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Prime centrum locaties</li>
                        <li class="flex items-center text-blue-100"><svg class="w-5 h-5 text-blue-300 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Snelle reservering</li>
                    </ul>
                    <a href="{{ route('register') ?? '#' }}" class="block w-full py-3 px-4 bg-white text-blue-600 font-bold text-center rounded-xl hover:bg-blue-50 transition">Kies Centrum</a>
                </div>

                <!-- Plan 3 -->
                <div class="bg-slate-50 p-8 rounded-3xl border border-slate-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Premium Parking</h3>
                    <div class="flex items-baseline gap-1 mb-6">
                        <span class="text-4xl font-extrabold text-slate-900">€6</span>
                        <span class="text-slate-500">/u</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center text-slate-600"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Beveiligde VIP locaties</li>
                        <li class="flex items-center text-slate-600"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>24/7 exclusieve toegang</li>
                        <li class="flex items-center text-slate-600"><svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Gratis laden (EV)</li>
                    </ul>
                    <a href="{{ route('register') ?? '#' }}" class="block w-full py-3 px-4 bg-white border-2 border-slate-200 text-slate-700 font-bold text-center rounded-xl hover:bg-slate-50 transition">Kies Premium</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Locaties -->
    <section id="locaties" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Populaire Locaties</h2>
                <p class="text-lg text-slate-600">Vind plekken in de drukste steden.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Location Cards -->
                <div class="group relative rounded-2xl overflow-hidden cursor-pointer">
                    <div class="absolute inset-0 bg-blue-900/40 group-hover:bg-blue-900/20 transition-all duration-300 z-10"></div>
                    <img src="https://images.unsplash.com/photo-1549646537-81427a13c19e?auto=format&fit=crop&q=80&w=400" alt="Rotterdam" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute bottom-6 left-6 z-20">
                        <h4 class="text-xl font-bold text-white mb-1">Rotterdam</h4>
                        <p class="text-white/80 text-sm">Centrum & Kop van Zuid</p>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden cursor-pointer">
                    <div class="absolute inset-0 bg-blue-900/40 group-hover:bg-blue-900/20 transition-all duration-300 z-10"></div>
                    <img src="https://images.unsplash.com/photo-1518098268026-4e89f1a2cd8e?auto=format&fit=crop&q=80&w=400" alt="Amsterdam" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute bottom-6 left-6 z-20">
                        <h4 class="text-xl font-bold text-white mb-1">Amsterdam</h4>
                        <p class="text-white/80 text-sm">Zuidas & Centrum</p>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden cursor-pointer">
                    <div class="absolute inset-0 bg-blue-900/40 group-hover:bg-blue-900/20 transition-all duration-300 z-10"></div>
                    <img src="https://images.unsplash.com/photo-1628102377465-385038cbe43b?auto=format&fit=crop&q=80&w=400" alt="Utrecht" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute bottom-6 left-6 z-20">
                        <h4 class="text-xl font-bold text-white mb-1">Utrecht</h4>
                        <p class="text-white/80 text-sm">Centraal Station</p>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden cursor-pointer">
                    <div class="absolute inset-0 bg-blue-900/40 group-hover:bg-blue-900/20 transition-all duration-300 z-10"></div>
                    <img src="https://images.unsplash.com/photo-1582845686001-c88c7f078e3c?auto=format&fit=crop&q=80&w=400" alt="Den Haag" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute bottom-6 left-6 z-20">
                        <h4 class="text-xl font-bold text-white mb-1">Den Haag</h4>
                        <p class="text-white/80 text-sm">Centrum</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. Waarom Kiezen Voor Ons (Features) -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Waarom kiezen voor Smart Parking?</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Sneller parkeren</h3>
                    <p class="text-slate-600">Geen zoektochten meer; rijd direct naar je gereserveerde plek.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Minder stress</h3>
                    <p class="text-slate-600">Start je afspraak of ritje naar de stad ontspannen en op tijd.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Live beschikbaarheid</h3>
                    <p class="text-slate-600">Altijd up-to-date status van beschikbare parkeerplekken.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Veilig betalen</h3>
                    <p class="text-slate-600">Transactions zijn 100% beveiligd via iDEAL en creditcard.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">Gebruiksvriendelijke app</h3>
                    <p class="text-slate-600">Alles wat je nodig hebt binnen handbereik op je smartphone.</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">24/7 ondersteuning</h3>
                    <p class="text-slate-600">Ons supportteam staat op elk moment van de dag klaar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. Reviews -->
    <section id="reviews" class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-slate-900 mb-4">Wat onze gebruikers zeggen</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Review 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative">
                    <div class="flex text-amber-400 mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 mb-6 italic">"Heerlijk om geen parkeerstress meer te hebben als ik naar Amsterdam ga. Ik reserveer vooraf en kan direct doorrijden."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=Lotte+V&background=random" alt="Lotte" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-slate-900">Lotte V.</h4>
                            <span class="text-sm text-slate-500">Zakelijke gebruiker</span>
                        </div>
                    </div>
                </div>

                <!-- Review 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative">
                    <div class="flex text-amber-400 mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 mb-6 italic">"De app werkt erg soepel. Vooral de integratie met navigatie is erg handig. Beste app die er is voor parkeren."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=Mark+D&background=random" alt="Mark" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-slate-900">Mark D.</h4>
                            <span class="text-sm text-slate-500">Dagtoerist</span>
                        </div>
                    </div>
                </div>

                <!-- Review 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 relative">
                    <div class="flex text-amber-400 mb-4">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-slate-600 mb-6 italic">"Tarief was transparant en de betaling ging automatisch. Erg tevreden, ga het vaker gebruiken."</p>
                    <div class="flex items-center gap-4">
                        <img src="https://ui-avatars.com/api/?name=Sara+J&background=random" alt="Sara" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-bold text-slate-900">Sara J.</h4>
                            <span class="text-sm text-slate-500">Student</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. Grote CTA Sectie -->
    <section class="py-24 relative overflow-hidden bg-blue-600">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-5xl font-extrabold text-white mb-8 leading-tight">Begin vandaag nog met slimmer parkeren</h2>
            <a href="{{ route('register') ?? '#' }}" class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-blue-600 bg-white rounded-full shadow-2xl hover:bg-slate-50 hover:scale-105 transition-all duration-300">
                Registreer Nu
            </a>
        </div>
    </section>

    <!-- 10. Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-6">
                        <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                        <span class="text-lg font-bold text-white">Smart Parking</span>
                    </div>
                    <p class="text-slate-400 text-sm">De oplossing voor stressvrij parkeren in de stad.</p>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Navigatie</h4>
                    <ul class="space-y-3">
                        <li><a href="#home" class="text-slate-400 hover:text-white transition text-sm">Home</a></li>
                        <li><a href="#over-ons" class="text-slate-400 hover:text-white transition text-sm">Over Ons</a></li>
                        <li><a href="#tarieven" class="text-slate-400 hover:text-white transition text-sm">Tarieven</a></li>
                        <li><a href="#locaties" class="text-slate-400 hover:text-white transition text-sm">Locaties</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Hulp nodig?</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-slate-400 hover:text-white transition text-sm">Support Center</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition text-sm">Contact</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition text-sm">Veelgestelde Vragen</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4 text-sm uppercase tracking-wider">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-slate-400 hover:text-white transition text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition text-sm">Algemene Voorwaarden</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition text-sm">Cookiebeleid</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">
                <p>&copy; {{ date('Y') }} Smart Parking. Alle rechten voorbehouden.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-slate-500 hover:text-white transition">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"/></svg>
                    </a>
                    <a href="#" class="text-slate-500 hover:text-white transition">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
