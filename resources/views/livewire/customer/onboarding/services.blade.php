<div>
    <h2 class="text-xl font-semibold mb-4">1. Cadastre seus serviços</h2>
    <p class="text-gray-600 mb-6">Adicione os serviços que sua empresa oferece</p>
    
    @foreach($services as $index => $service)
    <div class="grid grid-cols-12 gap-4 mb-4 items-end">
        <div class="col-span-5">
            <x-input 
                label="Nome do serviço" 
                wire:model="services.{{ $index }}.name" 
                placeholder="Ex: Corte de Cabelo" 
            />
        </div>
        <div class="col-span-3">
            <x-input 
                label="Duração (min)" 
                wire:model="services.{{ $index }}.duration_minutes" 
                type="number" 
            />
        </div>
        <div class="col-span-3">
            <x-input 
                label="Preço (opcional)" 
                wire:model="services.{{ $index }}.price" 
                prefix="R$" 
            />
        </div>
        <div class="col-span-1">
            @if($index > 0)
            <x-button 
                icon="o-trash" 
                wire:click="removeService({{ $index }})" 
                class="btn-ghost btn-sm text-error" 
            />
            @endif
        </div>
    </div>
    @endforeach
    
    <x-button 
        label="Adicionar outro serviço" 
        icon="o-plus" 
        wire:click="addService" 
        class="btn-ghost mt-2" 
    />
</div>