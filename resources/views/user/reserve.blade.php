@extends('layouts.app')
@section('title', 'Reserveren')
@section('page-title', 'Parkeerplaats Reserveren')

@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<style>
    #map {
        height: 400px;
        width: 100%;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="card relative overflow-hidden">
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

        <div class="relative z-10">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white border-b border-gray-300 dark:border-gray-600 pb-4 mb-6 uppercase tracking-wide">
                Nieuwe Reservering - Rotterdam
            </h2>

            @if($spotsWithStatus->isEmpty())
                <div class="text-center py-16 bg-gray-200 dark:bg-gray-800 rounded-xl border border-gray-700">
                    <p class="text-6xl mb-4 opacity-50"></p>
                    <p class="text-gray-600 dark:text-gray-300 font-semibold text-lg">Geen beschikbare parkeerplaatsen via de API</p>
                    <p class="text-brand-muted text-sm mt-2 uppercase tracking-widest">Probeer het later opnieuw</p>
                </div>
            @else
                
                <div id="map"></div>

                <form method="POST" action="{{ route('user.betaal') }}" class="space-y-6">
                    @csrf

                    <div class="bg-gray-200 dark:bg-gray-800 p-5 rounded-xl border border-gray-700 shadow-inner">
                        <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-2">Geselecteerde Parkeerplaats *</label>
                        <select id="parking_spot_select" name="external_parking_id" required class="form-input text-lg font-semibold h-14 bg-form-bg text-form-text border-form-border focus:ring-2 focus:ring-primary rounded-lg cursor-pointer">
                            <option value="" disabled selected>-- Klik op de kaart om een parkeerplaats te kiezen --</option>
                            @foreach($spotsWithStatus as $spot)
                                <option value="{{ $spot['id'] }}" {{ old('external_parking_id', $selectedSpotId ?? '') == $spot['id'] ? 'selected' : '' }} {{ $spot['reserved_status'] === 'active' ? 'disabled' : '' }}>
                                    {{ $spot['name'] }} – {{ $spot['city'] }} (€{{ number_format($spot['price_per_hour'] ?? 2.0, 2) }}/uur) 
                                    @if($spot['reserved_status'] === 'active')
                                        (Gereserveerd nu)
                                    @elseif($spot['reserved_status'] === 'upcoming')
                                        (Later gereserveerd)
                                    @else
                                        (Beschikbaar)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="bg-gray-200 dark:bg-gray-800 p-4 rounded-xl border border-gray-700">
                            <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-2">Datum *</label>
                            <input type="date" name="datum" value="{{ old('datum', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12">
                        </div>
                        <div class="bg-gray-200 dark:bg-gray-800 p-4 rounded-xl border border-gray-700">
                            <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-2">Starttijd *</label>
                            <select name="start_tijd" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12 cursor-pointer">
                                @for($i = 0; $i < 24; $i++)
                                    @php $t = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $t }}" {{ old('start_tijd', '09:00') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @php $t = sprintf('%02d:30', $i); @endphp
                                    <option value="{{ $t }}" {{ old('start_tijd') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="bg-gray-200 dark:bg-gray-800 p-4 rounded-xl border border-gray-700">
                            <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-2">Eindtijd *</label>
                            <select name="eind_tijd" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12 cursor-pointer">
                                @for($i = 0; $i < 24; $i++)
                                    @php $t = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $t }}" {{ old('eind_tijd', '11:00') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @php $t = sprintf('%02d:30', $i); @endphp
                                    <option value="{{ $t }}" {{ old('eind_tijd') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-200 dark:bg-gray-800 p-5 rounded-xl border border-gray-700 shadow-inner">
                        <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-3">Kies een voertuig *</label>
                        
                        <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-3">Mijn Voertuigen</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            <label class="flex flex-col p-4 border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-600 user-vehicle-btn ring-2 ring-blue-500 bg-blue-50/50 dark:bg-blue-900/30">
                                <input type="radio" name="voertuig_id" value="none" class="hidden" checked onchange="updateVehicleInputsGrid(this)">
                                <span class="font-bold text-gray-900 dark:text-white mb-1">✍️ Handmatig</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">Vul zelf de gegevens in</span>
                            </label>
                            
                            @if(isset($vehicles) && $vehicles->count() > 0)
                                @foreach($vehicles as $v)
                                    @php
                                        $vIcon = match($v->type) {
                                            'Auto' => '🚗',
                                            'Motor' => '🏍️',
                                            'Fiets' => '🚲',
                                            'Elektrisch' => '⚡',
                                            default => '🚙'
                                        };
                                    @endphp
                                    <label class="flex flex-col p-4 border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-xl cursor-pointer transition-all hover:bg-gray-200 dark:hover:bg-gray-600 user-vehicle-btn">
                                        <input type="radio" name="voertuig_id" value="{{ $v->id }}" class="hidden" 
                                            data-type="{{ $v->type }}" data-kenteken="{{ $v->license_plate }}" onchange="updateVehicleInputsGrid(this)">
                                        <span class="font-bold text-gray-900 dark:text-white mb-1">{{ $vIcon }} {{ $v->name }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $v->type }} • {{ $v->license_plate ?? 'Geen kenteken' }}</span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        
                        <div id="manual_input_section" class="transition-opacity duration-300">
                            <hr class="border-gray-300 dark:border-gray-600 mb-4">
                            <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-3">Of kies een voertuig type</label>
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                            @foreach(['Auto' => '🚗', 'Motor' => '🏍️', 'Fiets' => '🚲', 'Elektrisch' => '⚡'] as $type => $icon)
                                <label class="flex flex-col items-center p-3 border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 rounded-lg cursor-pointer transition-all manual-type-btn hover:bg-gray-600
                                {{ old('voertuig', 'Auto') === $type ? 'ring-2 ring-blue-500 bg-blue-900/30' : '' }}">
                                    <input type="radio" name="voertuig" id="type_{{ $type }}" value="{{ $type }}" class="hidden"
                                           {{ old('voertuig', 'Auto') === $type ? 'checked' : '' }}
                                           onchange="updateManualType(this)">
                                    <span class="text-3xl mb-2 drop-shadow-md">{{ $icon }}</span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-600 dark:text-gray-300">{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>

                        <div>
                            <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-2">Kenteken (optioneel)</label>
                            <input type="text" name="kenteken" id="manual_kenteken" value="{{ old('kenteken') }}"
                                   class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-mono tracking-widest uppercase border-none focus:ring-2 focus:ring-blue-500 h-12" placeholder="AA-123-BB" maxlength="15">
                        </div>
                        </div>
                    </div>

                    <button type="submit" id="submit_btn" class="btn btn-primary w-full py-4 text-lg tracking-widest uppercase shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                        Doorgaan naar betaling →
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

@if(!$spotsWithStatus->isEmpty())
<script>
    document.addEventListener('turbo:load', function () {
        // Initialize Map
        var map = L.map('map').setView([51.9225, 4.47917], 13); // Centered on Rotterdam

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var spots = @json($spotsWithStatus->values()->all());
        var selectEl = document.getElementById('parking_spot_select');

        // Custom markers
        var availableIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var reservedIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var orangeIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        spots.forEach(function(spot) {
            if (spot.lat && spot.lng) {
                var initialIcon = availableIcon;
                if (spot.reserved_status === 'active') initialIcon = reservedIcon;
                if (spot.reserved_status === 'upcoming') initialIcon = orangeIcon;
            
                var marker = L.marker([spot.lat, spot.lng], {
                    icon: initialIcon
                }).addTo(map);

                marker.spotId = spot.id;
                marker.spotName = spot.name;
                marker.spotPrice = spot.price_per_hour ? spot.price_per_hour.toFixed(2) : '2.00';

                var statusText = '<strong style="color:green;">Beschikbaar</strong>';
                if (spot.reserved_status === 'active') statusText = '<strong style="color:red;">Gereserveerd (nu actief)</strong>';
                if (spot.reserved_status === 'upcoming') statusText = '<strong style="color:orange;">Later vandaag gereserveerd</strong>';
                
                var popupContent = '<b>' + spot.name + '</b><br>' +
                                   'Prijs: €' + (spot.price_per_hour ? spot.price_per_hour.toFixed(2) : '2.00') + '/uur<br>' +
                                   'Status: ' + statusText + '<br>';
                                   
                if (spot.reserved_status !== 'active') {
                    popupContent += '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\'' + spot.id + '\')">Selecteer deze plek</button>';
                }

                marker.bindPopup(popupContent);
            }
        });
        
        // Handle Map -> Select change
        window.selectSpot = function(id) {
            selectEl.value = id;
            map.closePopup();
            // scroll down to form
            selectEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        };
        
        function updateMapStatus() {
            fetch('{{ route("user.reserve.status") }}')
                .then(response => response.json())
                .then(data => {
                    var reservedIds = data.reserved_spots || [];
                    var upcomingIds = data.upcoming_spots || [];
                    
                    // Update markers based on real-time status
                    map.eachLayer(function(layer) {
                        if (layer instanceof L.Marker && layer.spotId) {
                            var isReserved = reservedIds.includes(layer.spotId);
                            var isUpcoming = upcomingIds.includes(layer.spotId);
                            
                            var iconToUse = availableIcon;
                            if (isReserved) iconToUse = reservedIcon;
                            else if (isUpcoming) iconToUse = orangeIcon;
                            
                            layer.setIcon(iconToUse);
                            
                            var statusText = '<strong style="color:green;">Beschikbaar</strong>';
                            if (isReserved) statusText = '<strong style="color:red;">Gereserveerd (nu actief)</strong>';
                            else if (isUpcoming) statusText = '<strong style="color:orange;">Later vandaag gereserveerd</strong>';
                            
                            var popupContent = '<b>' + layer.spotName + '</b><br>' +
                                               'Prijs: €' + layer.spotPrice + '/uur<br>' +
                                               'Status: ' + statusText + '<br>';
                                               
                            if (!isReserved) {
                                popupContent += '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\'' + layer.spotId + '\')">Selecteer deze plek</button>';
                            }
                            
                            if (layer.getPopup()) {
                                layer.getPopup().setContent(popupContent);
                            }
                        }
                    });

                    // Update Select Options
                    Array.from(selectEl.options).forEach(function(option) {
                        if (option.value) {
                            var isReserved = reservedIds.includes(option.value);
                            var isUpcoming = upcomingIds.includes(option.value);
                            option.disabled = isReserved;
                            
                            // reset clean text first
                            var baseText = option.text.replace(' (Gereserveerd nu)', '').replace(' (Later gereserveerd)', '').replace(' (Beschikbaar)', '').trim();
                            
                            if (isReserved) {
                                option.text = baseText + ' (Gereserveerd nu)';
                            } else if (isUpcoming) {
                                option.text = baseText + ' (Later gereserveerd)';
                            } else {
                                option.text = baseText + ' (Beschikbaar)';
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching map status:', error));
        }
        
        // Start polling every 10 seconds
        setInterval(updateMapStatus, 10000);

        // Ensure form validation prevents selecting disabled reserved options
        document.querySelector('form').addEventListener('submit', function(e) {
            var selectedOption = selectEl.options[selectEl.selectedIndex];
            if (selectedOption.disabled || !selectEl.value) {
                e.preventDefault();
                alert('Selecteer a.u.b. een geldige, beschikbare parkeerplaats op de kaart of uit de lijst.');
            }
        });
    });

    
        function updateVehicleInputsGrid(radio) {
        var labels = document.querySelectorAll('.user-vehicle-btn');
        labels.forEach(el => el.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/30'));
        radio.parentElement.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/30');
        
        var type = radio.getAttribute('data-type');
        var kenteken = radio.getAttribute('data-kenteken');
        var manualKenteken = document.getElementById('manual_kenteken');
        var manualSection = document.getElementById('manual_input_section');
        
        if (radio.value === 'none') {
            
            manualKenteken.readOnly = false;
            manualKenteken.value = '';
            manualSection.classList.remove('opacity-50', 'pointer-events-none');
        } else {
            var targetRadio = document.getElementById('type_' + type);
            if (targetRadio) {
                targetRadio.checked = true;
                updateManualType(targetRadio);
            }
            if (kenteken) {
                manualKenteken.value = kenteken;
            } else {
                manualKenteken.value = '';
            }
            manualKenteken.readOnly = true;
            
            manualSection.classList.add('opacity-50', 'pointer-events-none');
        }
    }

    function updateManualType(radio) {
        document.querySelectorAll('.manual-type-btn').forEach(el => el.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-900/30'));
        radio.parentElement.classList.add('ring-2', 'ring-blue-500', 'bg-blue-900/30');
    }
</script>
@endif
@endsection
