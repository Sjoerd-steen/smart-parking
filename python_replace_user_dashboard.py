import re

with open('resources/views/user/dashboard.blade.php', 'r') as f:
    content = f.read()

# Replace the script section
script_pattern = r"<script>.*?</script>"
new_script = """<script>
    document.getElementById('lastUpdate').textContent = 'BIJGEWERKT: ' + new Date().toLocaleTimeString('nl-NL');
    
    // Initialiseer Leaflet map gecentreerd op Rotterdam
    var map = L.map('map').setView([51.9225, 4.47917], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var spots = @json($spots);
    var spotsArray = Object.values(spots);

    spotsArray.forEach(function(spot) {
        var statusColor = '#f43f5e'; // rood / bezet
        var isAvailable = false;
        if (spot.status === 'beschikbaar') {
            statusColor = '#10b981'; // groen
            isAvailable = true;
        }
        else if (spot.status === 'gereserveerd') statusColor = '#f59e0b'; // oranje

        var marker = L.circleMarker([spot.lat, spot.lng], {
            radius: 8,
            fillColor: statusColor,
            color: '#ffffff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);

        var popupContent = `
            <div class="font-sans text-gray-800 text-sm">
                <strong class="text-base">${spot.name}</strong><br>
                <span class="mt-1 inline-block px-2 py-0.5 rounded text-white text-xs font-bold" style="background-color: ${statusColor}">
                    ${spot.status.charAt(0).toUpperCase() + spot.status.slice(1)}
                </span><br>
                Prijs: €${Number(spot.price_per_hour).toFixed(2)} / uur`;
                
        if (isAvailable) {
            popupContent += `<br><a href="/user/reserveren?spot_id=${spot.id}" class="mt-2 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-xs no-underline text-center">Nu Reserveren</a>`;
        }
        
        popupContent += `</div>`;

        marker.bindPopup(popupContent);
    });

    setTimeout(() => location.reload(), 30000);
</script>"""
content = re.sub(script_pattern, new_script, content, flags=re.DOTALL)

with open('resources/views/user/dashboard.blade.php', 'w') as f:
    f.write(content)
