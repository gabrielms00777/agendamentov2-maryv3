<div>
    <x-form wire:submit="addChip" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-input 
                label="Nome do Chip" 
                wire:model="newChip.name" 
                placeholder="Ex: WhatsApp Principal" />
            <x-input 
                label="Número WhatsApp" 
                wire:model="newChip.phone_number" 
                mask="(##) #####-####" 
                placeholder="(99) 99999-9999" />
            <x-button 
                label="Adicionar Número" 
                type="submit" 
                icon="o-plus" 
                class="btn-primary self-end" 
                spinner />
        </div>
    </x-form>

    <x-table :headers="[
        ['key' => 'name', 'label' => 'Nome'],
        ['key' => 'phone_number', 'label' => 'Número'],
        ['key' => 'status', 'label' => 'Status'],
    ]" :rows="$chips">
        @scope('cell_status', $chip)
            @if($chip->connected)
                <x-badge value="Conectado" icon="o-check-badge" class="badge-success" />
            @else
                <x-badge value="Desconectado" icon="o-x-mark" class="badge-warning" />
            @endif
        @endscope

        @scope('actions', $chip)
            @if(!$chip->connected)
                <x-button 
                    icon="o-qr-code" 
                    wire:click="connectChip({{ $chip->id }})" 
                    spinner 
                    class="btn-ghost btn-sm" 
                    tooltip="Conectar" />
            @endif
            
            <x-button 
                icon="o-trash" 
                wire:click="deleteChip({{ $chip->id }})" 
                spinner 
                class="btn-ghost btn-sm text-error" 
                wire:confirm="Tem certeza que deseja remover este número?" />
        @endscope
    </x-table>

    <!-- Modal QR Code -->
    <x-modal wire:model="showQrModal" title="Conectar WhatsApp" separator>
        <div class="text-center py-6">
            {{-- <img src="{{ $qrCode }}" alt="QR Code" class="mx-auto w-64 h-64" /> --}}
            <img src="" alt="QR Code" class="mx-auto w-64 h-64" />
            <p class="mt-4 text-gray-600">Escaneie este QR Code no aplicativo do WhatsApp</p>
            
            <div class="mt-6">
                <x-button 
                    label="Já escaneei" 
                    icon="o-check" 
                    {{-- wire:click="checkConnection({{ $chipId }})"  --}}
                    wire:click="checkConnection(1)" 
                    spinner 
                    class="btn-primary" />
            </div>
        </div>
    </x-modal>
</div>