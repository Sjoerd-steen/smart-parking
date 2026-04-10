import re

filepath = 'resources/views/user/reserve.blade.php'
with open(filepath, 'r') as f:
    content = f.read()

old_select_block = """                        <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-2">Selecteer uw voertuig *</label>
                        <select id="user_vehicle_select" name="voertuig_id" class="form-input bg-form-bg text-form-text w-full border-form-border focus:ring-2 focus:ring-primary rounded-lg h-12 mb-4 cursor-pointer" onchange="updateVehicleInputs(this)">
                            <option value="none">-- Handmatig invullen --</option>
                            @if(isset($vehicles) && $vehicles->count() > 0)
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}" data-type="{{ $v->type }}" data-kenteken="{{ $v->kenteken }}">{{ $v->name }} ({{ $v->type }} - {{ $v->kenteken }})</option>
                                @endforeach
                            @endif
                        </select>
                        <hr class="border-gray-300 dark:border-gray-600 mb-4">"""

new_grid_block = """                        <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-3">Mijn Voertuigen</label>
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
                                            data-type="{{ $v->type }}" data-kenteken="{{ $v->kenteken }}" onchange="updateVehicleInputsGrid(this)">
                                        <span class="font-bold text-gray-900 dark:text-white mb-1">{{ $vIcon }} {{ $v->name }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $v->type }} • {{ $v->kenteken ?? 'Geen kenteken' }}</span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        
                        <div id="manual_input_section" class="transition-opacity duration-300">
                            <hr class="border-gray-300 dark:border-gray-600 mb-4">
                            <label class="form-label uppercase tracking-wider text-xs text-gray-500 dark:text-gray-400 mb-3">Of kies een voertuig type</label>"""

if old_select_block in content:
    content = content.replace(old_select_block, new_grid_block)

    # Now let's fix the closing div for manual input section and replace JS function
    content = content.replace('placeholder="AA-123-BB" maxlength="15">', 'placeholder="AA-123-BB" maxlength="15">\n                        </div>')
    
    js_to_add = """    function updateVehicleInputsGrid(radio) {
        var labels = document.querySelectorAll('.user-vehicle-btn');
        labels.forEach(el => el.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/30'));
        radio.parentElement.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50/50', 'dark:bg-blue-900/30');
        
        var type = radio.getAttribute('data-type');
        var kenteken = radio.getAttribute('data-kenteken');
        var manualKenteken = document.getElementById('manual_kenteken');
        var manualSection = document.getElementById('manual_input_section');
        
        if (radio.value === 'none') {
            document.querySelectorAll('.manual-type-btn input').forEach(r => r.disabled = false);
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
            document.querySelectorAll('.manual-type-btn input').forEach(r => r.disabled = true);
            manualSection.classList.add('opacity-50', 'pointer-events-none');
        }
    }"""
    
    # Replace the old updateVehicleInputs code
    content = re.sub(r'function updateVehicleInputs\(select\) \{.*?(?=function updateManualType)', js_to_add + '\n\n    ', content, flags=re.DOTALL)
    
    with open(filepath, 'w') as f:
        f.write(content)
        print("Updated reserve.blade.php")
else:
    print("Could not find the select block.")
    
