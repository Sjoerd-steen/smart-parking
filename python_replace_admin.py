import re

with open('resources/views/admin/dashboard.blade.php', 'r') as f:
    content = f.read()

# Replace the grid with a map div
grid_pattern = r"\{\{\-\- Grid van parkeerplekken \-\-\}\}.*?</div>\s*\{\{\-\- Legenda \-\-\}\}"
map_html = """{{-- Map van parkeerplekken --}}
            <div id="map" class="w-full h-[500px] rounded-xl border border-gray-600 shadow-md mb-4" style="z-index: 1;"></div>

            {{-- Legenda --}}"""
content = re.sub(grid_pattern, map_html, content, flags=re.DOTALL)

# Add leaflet css and js at the top of content section
content = content.replace("@section('content')", "@section('content')\n<link rel=\"stylesheet\" href=\"https://unpkg.com/leaflet@1.9.4/dist/leaflet.css\" crossorigin=\"\" />\n<script src=\"https://unpkg.com/leaflet@1.9.4/dist/leaflet.js\" crossorigin=\"\"></script>")

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
        if (spot.status === 'beschikbaar') statusColor = '#10b981'; // groen
        else if (spot.status === 'gereserveerd') statusColor = '#f59e0b'; // oranje

        var marker = L.circleMarker([spot.lat, spot.lng], {
            radius: 8,
            fillColor: statusColor,
            color: '#ffffff',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);

        marker.bindPopup(`
            <div class="font-sans text-gray-800 text-sm">
                <strong class="text-base">${spot.name}</strong><br>
                <span class="mt-1 inline-block px-2 py-0.5 rounded text-white text-xs font-bold" style="background-color: ${statusColor}">
                    ${(spot.status || "onbekend").charAt(0).toUpperCase() + (spot.status || "onbekend").slice(1)}
                </span><br>
                Prijs: €${Number(spot.price_per_hour || 2).toFixed(2)} / uur
            </div>
        `);
    });

    setTimeout(() => location.reload(), 30000);
</script>"""
content = re.sub(script_pattern, new_script, content, flags=re.DOTALL)

with open('resources/views/admin/dashboard.blade.php', 'w') as f:
    f.write(content)
