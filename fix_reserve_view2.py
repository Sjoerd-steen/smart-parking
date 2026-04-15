import re

with open('resources/views/user/reserve.blade.php', 'r') as f:
    content = f.read()

pattern_loop = r'''var marker = L\.marker\(\[spot\.lat, spot\.lng\], \{\n\s*icon: spot\.reserved \? reservedIcon : availableIcon\n\s*\}\)\.addTo\(map\);'''
replacement_loop = '''var marker = L.marker([spot.lat, spot.lng], {
                    icon: spot.reserved ? reservedIcon : availableIcon
                }).addTo(map);

                marker.spotId = spot.id;
                marker.spotName = spot.name;
                marker.spotPrice = spot.price_per_hour ? spot.price_per_hour.toFixed(2) : '2.00';'''

content = re.sub(pattern_loop, replacement_loop, content)

pattern_end_map = r'''// Ensure form validation prevents selecting disabled reserved options'''
replacement_end_map = '''function updateMapStatus() {
            fetch('{{ route("user.reserve.status") }}')
                .then(response => response.json())
                .then(data => {
                    var reservedIds = data.reserved_spots || [];
                    
                    // Update markers based on real-time status
                    map.eachLayer(function(layer) {
                        if (layer instanceof L.Marker && layer.spotId) {
                            var isReserved = reservedIds.includes(layer.spotId);
                            
                            layer.setIcon(isReserved ? reservedIcon : availableIcon);
                            
                            var statusText = isReserved ? '<strong style="color:red;">Gereserveerd</strong>' : '<strong style="color:green;">Beschikbaar</strong>';
                            
                            var popupContent = '<b>' + layer.spotName + '</b><br>' +
                                               'Prijs: €' + layer.spotPrice + '/uur<br>' +
                                               'Status: ' + statusText + '<br>';
                                               
                            if (!isReserved) {
                                popupContent += '<button type="button" class="bg-blue-600 hover:bg-blue-700 !text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\\'' + layer.spotId + '\\')">Selecteer deze plek</button>';
                            }
                            
                            // layer.bindPopup(popupContent);
                            if (layer.getPopup()) {
                                layer.getPopup().setContent(popupContent);
                            }
                        }
                    });

                    // Update Select Options
                    Array.from(selectEl.options).forEach(function(option) {
                        if (option.value) {
                            var isReserved = reservedIds.includes(option.value);
                            option.disabled = isReserved;
                            
                            if (isReserved && !option.text.includes('(Gereserveerd)')) {
                                option.text = option.text + ' (Gereserveerd)';
                            } else if (!isReserved && option.text.includes('(Gereserveerd)')) {
                                option.text = option.text.replace(' (Gereserveerd)', '');
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching map status:', error));
        }
        
        // Start polling every 10 seconds
        setInterval(updateMapStatus, 10000);

        // Ensure form validation prevents selecting disabled reserved options'''

content = re.sub(pattern_end_map, replacement_end_map, content)

with open('resources/views/user/reserve.blade.php', 'w') as f:
    f.write(content)
