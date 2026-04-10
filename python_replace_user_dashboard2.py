import re

with open('resources/views/user/reserve.blade.php', 'r') as f:
    content = f.read()

# Make the map popup also contain the "nu reserveren" button, but instead of navigating away, just select the option.
script_pattern = r"var popupContent = '<b>' \+ spot.name.*?marker\.bindPopup\(popupContent\);"
new_script = """var popupContent = '<b>' + spot.name + '</b><br>' +
                                   'Prijs: €' + (spot.price_per_hour ? spot.price_per_hour.toFixed(2) : '2.00') + '/uur<br>' +
                                   'Status: ' + statusText + '<br>';
                                   
                if (!spot.reserved) {
                    popupContent += '<button type="button" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-1 px-3 mt-2 rounded text-xs no-underline text-center" onclick="event.preventDefault(); selectSpot(\\'' + spot.id + '\\')">Selecteer deze plek</button>';
                }

                marker.bindPopup(popupContent);"""
                
content = re.sub(script_pattern, new_script, content, flags=re.DOTALL)

with open('resources/views/user/reserve.blade.php', 'w') as f:
    f.write(content)
