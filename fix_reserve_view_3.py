import re

with open('resources/views/user/reserve.blade.php', 'r') as f:
    content = f.read()

# Update loop spots
pattern_opts = r'''<option value="\{\{ \$spot\['id'\] \}\}" \{\{ old\('external_parking_id', \$selectedSpotId \?\? ''\) == \$spot\['id'\] \? 'selected' : '' \}\} \{\{ \$spot\['reserved'\] \? 'disabled' : '' \}\}>
                                    \{\{ \$spot\['name'\] \}\} – \{\{ \$spot\['city'\] \}\} \(€\{\{ number_format\(\$spot\['price_per_hour'\] \?\? 2\.0, 2\) \}\}\/uur\) \{\{ \$spot\['reserved'\] \? '\(Gereserveerd\)' : '' \}\}
                                </option>'''

replacement_opts = '''<option value="{{ $spot['id'] }}" {{ old('external_parking_id', $selectedSpotId ?? '') == $spot['id'] ? 'selected' : '' }} {{ $spot['reserved_status'] === 'active' ? 'disabled' : '' }}>
                                    {{ $spot['name'] }} – {{ $spot['city'] }} (€{{ number_format($spot['price_per_hour'] ?? 2.0, 2) }}/uur) 
                                    @if($spot['reserved_status'] === 'active')
                                        (Gereserveerd nu)
                                    @elseif($spot['reserved_status'] === 'upcoming')
                                        (Later gereserveerd)
                                    @else
                                        (Beschikbaar)
                                    @endif
                                </option>'''

content = re.sub(pattern_opts, replacement_opts, content)

# Map and leaflet custom markers logic
pattern_map = r'''        var reservedIcon = new L\.Icon\(\{
            iconUrl: 'https://raw\.githubusercontent\.com/pointhi/leaflet-color-markers/master/img/marker-icon-red\.png',
            shadowUrl: 'https://cdnjs\.cloudflare\.com/ajax/libs/leaflet/0\.7\.7/images/marker-shadow\.png',
            iconSize: \[25, 41\],
            iconAnchor: \[12, 41\],
            popupAnchor: \[1, -34\],
            shadowSize: \[41, 41\]
        \}\);

        spots\.forEach\(function\(spot\) \{
            if \(spot\.lat && spot\.lng\) \{
                var marker = L\.marker\(\[spot\.lat, spot\.lng\], \{
                    icon: spot\.reserved \? reservedIcon : availableIcon
                \}\)\.addTo\(map\);

                marker\.spotId = spot\.id;
                marker\.spotName = spot\.name;
                marker\.spotPrice = spot\.price_per_hour \? spot\.price_per_hour\.toFixed\(2\) : '2\.00';

                var statusText = spot\.reserved \? '<strong style="color:red;">Gereserveerd</strong>' : '<strong style="color:green;">Beschikbaar</strong>';
                
                var popupContent = '<b>' \+ spot\.name \+ '</b><br>' \+
                                   'Prijs: €' \+ \(spot\.price_per_hour \? spot\.price_per_hour\.toFixed\(2\) : '2\.00'\) \+ '/uur<br>' \+
                                   'Status: ' \+ statusText \+ '<br>';
                                   
                if \(!spot\.reserved\) \{
                    popupContent \+= '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event\.preventDefault\(\); selectSpot\(\\\'' \+ spot\.id \+ '\\'\)">Selecteer deze plek</button>';
                \}

                marker\.bindPopup\(popupContent\);
            \}
        \}\);'''

replacement_map = '''        var reservedIcon = new L.Icon({
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
                    popupContent += '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\\'' + spot.id + '\\')">Selecteer deze plek</button>';
                }

                marker.bindPopup(popupContent);
            }
        });'''

content = re.sub(pattern_map, replacement_map, content)

# Polling JS
pattern_polling = r'''        function updateMapStatus\(\) \{
            fetch\('\{\{ route\("user\.reserve\.status"\) \}\}'\)
                \.then\(response => response\.json\(\)\)
                \.then\(data => \{
                    var reservedIds = data\.reserved_spots \|\| \[\];
                    
                    // Update markers based on real-time status
                    map\.eachLayer\(function\(layer\) \{
                        if \(layer instanceof L\.Marker && layer\.spotId\) \{
                            var isReserved = reservedIds\.includes\(layer\.spotId\);
                            
                            layer\.setIcon\(isReserved \? reservedIcon : availableIcon\);
                            
                            var statusText = isReserved \? '<strong style="color:red;">Gereserveerd</strong>' : '<strong style="color:green;">Beschikbaar</strong>';
                            
                            var popupContent = '<b>' \+ layer\.spotName \+ '</b><br>' \+
                                               'Prijs: €' \+ layer\.spotPrice \+ '/uur<br>' \+
                                               'Status: ' \+ statusText \+ '<br>';
                                               
                            if \(!isReserved\) \{
                                popupContent \+= '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event\.preventDefault\(\); selectSpot\(\\\'' \+ layer\.spotId \+ '\\'\)">Selecteer deze plek</button>';
                            \}
                            
                            // layer\.bindPopup\(popupContent\);
                            if \(layer\.getPopup\(\)\) \{
                                layer\.getPopup\(\)\.setContent\(popupContent\);
                            \}
                        \}
                    \}\);

                    // Update Select Options
                    Array\.from\(selectEl\.options\)\.forEach\(function\(option\) \{
                        if \(option\.value\) \{
                            var isReserved = reservedIds\.includes\(option\.value\);
                            option\.disabled = isReserved;
                            
                            if \(isReserved && !option\.text\.includes\('\(Gereserveerd\)'\)\) \{
                                option\.text = option\.text \+ ' \(Gereserveerd\)';
                            \} else if \(!isReserved && option\.text\.includes\('\(Gereserveerd\)'\)\) \{
                                option\.text = option\.text\.replace\(' \(Gereserveerd\)', ''\);
                            \}
                        \}
                    \}\);
                \}\)
                \.catch\(error => console\.error\('Error fetching map status:', error\)\);
        \}'''

replacement_polling = '''        function updateMapStatus() {
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
                                popupContent += '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\\'' + layer.spotId + '\\')">Selecteer deze plek</button>';
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
        }'''

content = re.sub(pattern_polling, replacement_polling, content)

with open('resources/views/user/reserve.blade.php', 'w') as f:
    f.write(content)

