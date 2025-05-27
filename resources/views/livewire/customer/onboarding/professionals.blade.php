<div>
    <h2 class="text-xl font-semibold mb-4">2. Cadastre seus profissionais</h2>
    <p class="text-gray-600 mb-6">Adicione os profissionais que atendem em sua empresa</p>
    
    @foreach($professionals as $index => $professional)
    <div class="bg-base-100 p-4 rounded-lg mb-4 shadow-sm">
        <div class="grid grid-cols-12 gap-4 mb-3">
            <div class="col-span-12 md:col-span-6">
                <x-input 
                    label="Nome do profissional" 
                    wire:model="professionals.{{ $index }}.name" 
                    placeholder="Ex: Maria Silva" 
                />
            </div>
            <div class="col-span-12 md:col-span-6">
                @foreach ($availableServices as $key => $service)
                    <x-checkbox 
                        label="{{ $service }}"
                        wire:model="professionals.{{ $index }}.services"
                    />
                @endforeach
                {{-- <x-checkbox 
                    label="Serviços realizados"
                    wire:model="professionals.{{ $index }}.services"
                    :options="$availableServices"
                    multiple
                /> --}}
            </div>
        </div>
        
        @if($index > 0)
        <div class="flex justify-end">
            <x-button 
                icon="o-trash" 
                wire:click="removeProfessional({{ $index }})" 
                class="btn-ghost btn-sm text-error" 
                label="Remover" 
            />
        </div>
        @endif
    </div>
    @endforeach
    
    <x-button 
        label="Adicionar outro profissional" 
        icon="o-plus" 
        wire:click="addProfessional" 
        class="btn-ghost mt-2" 
    />
</div>