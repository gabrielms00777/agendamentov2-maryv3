<div>
    <x-header title="Agendamentos" separator>
        <x-slot:middle class="!justify-end">
            <x-input 
                icon="o-magnifying-glass" 
                placeholder="Buscar por cliente..." 
                wire:model.live.debounce="search" 
                clearable />
        </x-slot:middle>
        <x-slot:actions>
            <x-button 
                icon="o-funnel" 
                wire:click="$toggle('showDrawer')" 
                class="btn-ghost" />
            <x-button 
                icon="o-plus" 
                label="Novo" 
                wire:click="create" 
                class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <!-- Tabela de Agendamentos -->
    <x-card>
        @php
            $headers = [
                ['key' => 'date', 'label' => 'Data', 'class' => 'w-32'],
                ['key' => 'time', 'label' => 'Hora', 'class' => 'w-20'],
                ['key' => 'client_name', 'label' => 'Cliente'],
                ['key' => 'service.name', 'label' => 'Serviço'],
                ['key' => 'professional.name', 'label' => 'Profissional'],
                ['key' => 'status', 'label' => 'Status', 'class' => 'w-32'],
            ];
        @endphp

        <x-table 
            :headers="$headers" 
            :rows="$appointments" 
            :sort-by="$sortBy"
            with-pagination
            link="/appointments/{id}">

            <!-- Coluna de Data -->
            @scope('cell_date', $appointment)
                <div class="text-center">
                    <div class="text-xs uppercase text-gray-500">
                        {{ $appointment->date->isoFormat('ddd') }}
                    </div>
                    <div class="font-bold">
                        {{ $appointment->date->format('d/m/Y') }}
                    </div>
                </div>
            @endscope

            <!-- Coluna de Hora -->
            @scope('cell_time', $appointment)
                <span class="font-mono">
                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                </span>
            @endscope

            <!-- Coluna de Status -->
            @scope('cell_status', $appointment)
                <x-badge :value="$appointment->status" @class([
                    'badge-success' => $appointment->status === AppointmentStatus::CONFIRMED->value,
                    'badge-warning' => $appointment->status === AppointmentStatus::PENDING->value,
                    'badge-error' => $appointment->status === AppointmentStatus::CANCELED->value,
                    'badge-info' => $appointment->status === AppointmentStatus::COMPLETED->value,
                ]) />
            @endscope

            <!-- Ações -->
            @scope('actions', $appointment)
                <x-button 
                    icon="o-pencil" 
                    wire:click="edit({{ $appointment->id }})" 
                    spinner 
                    class="btn-ghost btn-sm" />
                
                <x-button 
                    icon="o-trash" 
                    wire:click="delete({{ $appointment->id }})" 
                    spinner 
                    class="btn-ghost btn-sm text-red-500" 
                    wire:confirm="Tem certeza que deseja excluir este agendamento?" />
            @endscope
        </x-table>
    </x-card>

    <!-- Modal para Criar/Editar -->
    <x-modal wire:model="showModal" :title="$currentAppointment ? 'Editar Agendamento' : 'Novo Agendamento'" separator>
        <x-form wire:submit="save">
            <x-input 
                label="Cliente" 
                wire:model="currentAppointment.client_name" 
                icon="o-user" />
            
            <x-input 
                label="Telefone" 
                wire:model="currentAppointment.client_phone" 
                icon="o-phone" 
                mask="(##) #####-####" />
            
            <x-select 
                label="Serviço" 
                wire:model="currentAppointment.service_id" 
                :options="$services" 
                option-value="id" 
                option-label="name" />
            
            <x-select 
                label="Profissional" 
                wire:model="currentAppointment.professional_id" 
                :options="$professionals" 
                option-value="id" 
                option-label="name" />
            
            <x-datetime 
                label="Data" 
                wire:model="currentAppointment.date" 
                icon="o-calendar" />
            
            <x-input 
                label="Hora" 
                wire:model="currentAppointment.time" 
                type="time" 
                icon="o-clock" />
            
            <x-select 
                label="Status" 
                wire:model="currentAppointment.status" 
                :options="$statusOptions" 
                option-value="value" 
                option-label="label" />

            <x-slot:actions>
                <x-button label="Cancelar" @click="$wire.showModal = false" />
                <x-button label="Salvar" type="submit" icon="o-check" class="btn-primary" spinner />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <!-- Drawer de Filtros -->
    <x-drawer 
        wire:model="showDrawer" 
        title="Filtrar Agendamentos" 
        separator 
        right 
        class="lg:w-1/3">
        
        <x-form>
            <x-select 
                label="Status" 
                wire:model="filters.status" 
                :options="$statusOptions" 
                placeholder="Todos" 
                option-value="value" 
                option-label="label" />
            
            <x-select 
                label="Serviço" 
                wire:model="filters.service" 
                :options="$services" 
                placeholder="Todos" 
                option-value="id" 
                option-label="name" />
            
            <x-select 
                label="Profissional" 
                wire:model="filters.professional" 
                :options="$professionals" 
                placeholder="Todos" 
                option-value="id" 
                option-label="name" />
            
            <x-radio 
                label="Período" 
                wire:model="filters.date_range" 
                :options="[
                    ['id' => 'today', 'name' => 'Hoje'],
                    ['id' => 'week', 'name' => 'Esta semana'],
                    ['id' => 'month', 'name' => 'Este mês'],
                ]" 
                option-value="id" 
                option-label="name" />
        </x-form>

        <x-slot:actions>
            <x-button 
                label="Limpar Filtros" 
                wire:click="resetFilters" 
                icon="o-arrow-path" 
                spinner 
                class="btn-ghost" />
            
            <x-button 
                label="Aplicar" 
                @click="$wire.showDrawer = false" 
                icon="o-check" 
                class="btn-primary" />
        </x-slot:actions>
    </x-drawer>
</div>