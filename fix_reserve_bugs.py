import re

filepath = 'resources/views/user/reserve.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

# Fix 1: $v->kenteken -> $v->license_plate
content = content.replace('$v->kenteken', '$v->license_plate')
content = content.replace('data-kenteken="{{ $v->license_plate }}"', 'data-kenteken="{{ $v->license_plate }}"')

# Fix 2: Remove disabled = true for radio buttons so the form submits successfully
content = content.replace("document.querySelectorAll('.manual-type-btn input').forEach(r => r.disabled = false);", "")
content = content.replace("document.querySelectorAll('.manual-type-btn input').forEach(r => r.disabled = true);", "")

# Fix 3: Make time selection easier by using a nicely styled select dropdown instead of type="time"
old_start_time = '<input type="time" name="start_tijd" value="{{ old(\'start_tijd\', \'09:00\') }}" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12">'
new_start_time = """<select name="start_tijd" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12 cursor-pointer">
                                @for($i = 0; $i < 24; $i++)
                                    @php $t = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $t }}" {{ old('start_tijd', '09:00') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @php $t = sprintf('%02d:30', $i); @endphp
                                    <option value="{{ $t }}" {{ old('start_tijd') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endfor
                            </select>"""

old_end_time = '<input type="time" name="eind_tijd" value="{{ old(\'eind_tijd\', \'11:00\') }}" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12">'
new_end_time = """<select name="eind_tijd" required class="form-input bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white border-none focus:ring-2 focus:ring-blue-500 h-12 cursor-pointer">
                                @for($i = 0; $i < 24; $i++)
                                    @php $t = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $t }}" {{ old('eind_tijd', '11:00') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @php $t = sprintf('%02d:30', $i); @endphp
                                    <option value="{{ $t }}" {{ old('eind_tijd') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endfor
                            </select>"""

content = content.replace(old_start_time, new_start_time)
content = content.replace(old_end_time, new_end_time)

with open(filepath, 'w') as f:
    f.write(content)
print("reserve.blade.php updated")


# Fix 4: Add reserve button to the dashboard map
dash_path = 'resources/views/user/dashboard.blade.php'
with open(dash_path, 'r') as f:
    dash_content = f.read()

# Modify popup logic
old_popup = """                <span class="mt-1 inline-block px-2 py-0.5 rounded text-gray-900 dark:text-white text-xs font-bold" style="background-color: ${statusColor}">
                    ${spot.status.charAt(0).toUpperCase() + spot.status.slice(1)}
                </span><br>
                Prijs: €${Number(spot.price_per_hour).toFixed(2)} / uur
            </div>"""

new_popup = """                <span class="mt-1 inline-block px-2 py-0.5 rounded text-white text-xs font-bold" style="background-color: ${statusColor}">
                    ${spot.status.charAt(0).toUpperCase() + spot.status.slice(1)}
                </span><br>
                Prijs: €${Number(spot.price_per_hour).toFixed(2)} / uur
            </div>
            ${spot.status === 'beschikbaar' ? `<a href="/user/reserve?spot_id=${spot.id}" class="mt-3 block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-1.5 px-3 rounded-lg text-xs no-underline transition-colors shadow-sm">Reserveer deze plek →</a>` : ''}
"""

if old_popup in dash_content:
    dash_content = dash_content.replace(old_popup, new_popup)
    with open(dash_path, 'w') as f:
        f.write(dash_content)
    print("dashboard.blade.php updated")
else:
    print("Could not find popup logic in dashboard.blade.php")
