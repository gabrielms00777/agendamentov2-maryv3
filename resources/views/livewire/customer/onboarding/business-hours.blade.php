<div>
    <h2 class="text-xl font-semibold mb-4">3. Defina seus horários de funcionamento</h2>
    <p class="text-gray-600 mb-6">Marque os dias que sua empresa atende e configure os horários</p>
    
    <div class="space-y-4">
        @foreach($weekdays as $day)
        <div class="bg-base-100 p-4 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-medium">{{ $day }}</h3>
                <x-toggle 
                    wire:model="workingDays.{{ $day }}" 
                    wire:click="toggleWorkingDay('{{ $day }}')"
                />
            </div>
            
            @if($workingDays[$day])
                @foreach($businessHours[$day] as $blockIndex => $block)
                <div class="grid grid-cols-12 gap-4 items-end mb-3">
                    <div class="col-span-5 md:col-span-3">
                        <x-input 
                            label="Abre às" 
                            wire:model="businessHours.{{ $day }}.{{ $blockIndex }}.start" 
                            type="time" 
                        />
                    </div>
                    <div class="col-span-5 md:col-span-3">
                        <x-input 
                            label="Fecha às" 
                            wire:model="businessHours.{{ $day }}.{{ $blockIndex }}.end" 
                            type="time" 
                        />
                    </div>
                    <div class="col-span-2 md:col-span-6 flex items-end">
                        @if($blockIndex > 0)
                        <x-button 
                            icon="o-trash" 
                            wire:click="removeTimeBlock('{{ $day }}', {{ $blockIndex }})" 
                            class="btn-ghost btn-sm text-error" 
                        />
                        @endif
                    </div>
                </div>
                @endforeach
                
                <x-button 
                    label="Adicionar outro horário" 
                    icon="o-plus" 
                    wire:click="addTimeBlock('{{ $day }}')" 
                    class="btn-ghost btn-sm mt-2" 
                />
            @else
                <div class="text-gray-500 italic">
                    Não trabalha neste dia
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>