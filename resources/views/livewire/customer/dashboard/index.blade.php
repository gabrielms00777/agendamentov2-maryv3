<div>
    <x-header title="Dashboard" subtitle="Visão geral do seu negócio" separator>
        <x-slot:actions>
            <x-button icon="o-arrow-path" class="btn-ghost" wire:click="loadData" spinner />
        </x-slot:actions>
    </x-header>

    <!-- Cards de Métricas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total de agendamentos hoje -->
        <x-stat
            title="Agendamentos Hoje"
            :value="$todayStats['total']"
            icon="o-calendar"
            description="{{ now()->format('d/m/Y') }}"
            color="text-blue-500" />

        <!-- Próximo horário -->
        <x-stat
            title="Próximo Horário"
            :value="$nextAppointment ? \Carbon\Carbon::parse($nextAppointment->time)->format('H:i') : 'Nenhum'"
            :description="$nextAppointment ? $nextAppointment->client_name : ''"
            icon="o-clock"
            color="text-purple-500" />

        <!-- Chips conectados -->
        <x-stat
            title="Chips Conectados"
            :value="$connectedChipsCount"
            icon="o-signal"
            description="WhatsApp ativo"
            color="text-green-500" />

        <!-- Profissionais ativos -->
        <x-stat
            title="Profissionais Ativos"
            :value="$activeProfessionalsCount"
            icon="o-user-group"
            description="Em atendimento"
            color="text-orange-500" />
    </div>

    <!-- Grid Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendário e Agendamentos -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Calendário -->
            <x-card title="Calendário" separator shadow>
                <div wire:ignore>
                    <div 
                        x-data="{
                            events: @entangle('todaysAppointments').defer,
                            init() {
                                const calendar = new FullCalendar.Calendar(this.$el, {
                                    initialView: 'dayGridMonth',
                                    events: this.events.map(event => ({
                                        title: `${event.time} - ${event.client_name}`,
                                        start: event.date,
                                        extendedProps: {
                                            status: event.status
                                        },
                                        className: this.getEventClass(event.status)
                                    })),
                                    eventDidMount: function(info) {
                                        const status = info.event.extendedProps.status;
                                        const dot = document.createElement('div');
                                        dot.className = `fc-event-dot ${status === 'confirmed' ? 'bg-green-500' : 'bg-yellow-500'}`;
                                        info.el.querySelector('.fc-event-title').prepend(dot);
                                    }
                                });
                                calendar.render();
                                
                                // Atualizar quando os dados mudarem
                                this.$watch('events', () => {
                                    calendar.removeAllEvents();
                                    calendar.addEventSource(this.events.map(event => ({
                                        title: `${event.time} - ${event.client_name}`,
                                        start: event.date,
                                        extendedProps: {
                                            status: event.status
                                        },
                                        className: this.getEventClass(event.status)
                                    })));
                                });
                            },
                            getEventClass(status) {
                                return status === 'confirmed' ? 'bg-green-100 text-green-800 border-green-300' : 
                                       status === 'pending' ? 'bg-yellow-100 text-yellow-800 border-yellow-300' :
                                       'bg-gray-100 text-gray-800 border-gray-300';
                            }
                        }"
                        class="h-96 w-full"
                        id="calendar">
                    </div>
                </div>
            </x-card>

            <!-- Lista de agendamentos do dia -->
            <x-card title="Agendamentos de Hoje" separator shadow>
                @if($todaysAppointments->count() > 0)
                    <div class="space-y-3">
                        @foreach($todaysAppointments as $appointment)
                        <x-list-item :item="$appointment" no-separator>
                            <x-slot:avatar>
                                <div class="text-center w-12">
                                    <div class="font-bold text-lg">
                                        {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                    </div>
                                </div>
                            </x-slot:avatar>
                            
                            <x-slot:title>
                                {{ $appointment->client_name }}
                                <x-badge :value="$appointment->status" @class([
                                    'badge-success' => $appointment->status === 'confirmed',
                                    'badge-warning' => $appointment->status === 'pending',
                                    'badge-error' => $appointment->status === 'canceled',
                                ]) />
                            </x-slot:title>
                            
                            <x-slot:subtitle>
                                <div class="flex flex-wrap gap-2">
                                    <x-badge :value="$appointment->service->name" icon="o-scissors" class="badge-outline badge-sm" />
                                    <x-badge :value="$appointment->professional->name" icon="o-user" class="badge-outline badge-sm" />
                                </div>
                            </x-slot:subtitle>
                            
                            <x-slot:actions>
                                <x-button 
                                    icon="o-phone" 
                                    class="btn-circle btn-ghost btn-sm text-green-500" 
                                    tooltip="Ligar para cliente" 
                                    wire:click="callClient('{{ $appointment->client_phone }}')" />
                                
                                <x-dropdown>
                                    <x-menu-item 
                                        title="Confirmar" 
                                        icon="o-check-badge" 
                                        wire:click="confirmAppointment({{ $appointment->id }})" />
                                    <x-menu-item 
                                        title="Cancelar" 
                                        icon="o-x-mark" 
                                        wire:click="cancelAppointment({{ $appointment->id }})" />
                                    <x-menu-separator />
                                    <x-menu-item 
                                        title="Detalhes" 
                                        icon="o-eye" 
                                        {{-- link="{{ route('appointments.show', $appointment->id) }}" /> --}}
                                        />
                                </x-dropdown>
                            </x-slot:actions>
                        </x-list-item>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <x-icon name="o-calendar" class="w-12 h-12 mx-auto text-gray-300" />
                        <p class="mt-2">Nenhum agendamento para hoje</p>
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Próximos Agendamentos e Ações Rápidas -->
        <div class="space-y-6">
            <!-- Próximos Agendamentos -->
            <x-card title="Próximos Agendamentos" separator shadow>
                @if($nextAppointment)
                    <div class="space-y-4">
                        <x-list-item :item="$nextAppointment" no-separator class="border border-green-200 bg-green-50 rounded-lg">
                            <x-slot:avatar>
                                <div class="text-center">
                                    <div class="text-xs uppercase text-gray-500">
                                        {{ \Carbon\Carbon::parse($nextAppointment->date)->isoFormat('ddd') }}
                                    </div>
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ \Carbon\Carbon::parse($nextAppointment->date)->format('d') }}
                                    </div>
                                </div>
                            </x-slot:avatar>
                            
                            <x-slot:title>
                                <div class="font-bold">{{ $nextAppointment->client_name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($nextAppointment->time)->format('H:i') }}
                                </div>
                            </x-slot:title>
                            
                            <x-slot:subtitle>
                                <x-badge :value="$nextAppointment->service->name" class="badge-outline badge-sm" />
                            </x-slot:subtitle>
                        </x-list-item>

                        @foreach($upcomingAppointments as $appointment)
                        <x-list-item :item="$appointment" no-separator class="border rounded-lg">
                            <x-slot:avatar>
                                <div class="text-center w-12">
                                    <div class="text-xs uppercase text-gray-500">
                                        {{ \Carbon\Carbon::parse($appointment->date)->isoFormat('ddd') }}
                                    </div>
                                    <div class="font-bold">
                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d') }}
                                    </div>
                                </div>
                            </x-slot:avatar>
                            
                            <x-slot:title>
                                <div class="font-medium">{{ $appointment->client_name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                </div>
                            </x-slot:title>
                        </x-list-item>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <x-icon name="o-calendar" class="w-12 h-12 mx-auto text-gray-300" />
                        <p class="mt-2">Nenhum agendamento futuro</p>
                    </div>
                @endif
                
                <x-slot:actions>
                    <x-button label="Ver todos" icon="o-arrow-right" link="{{ route('appointments.index') }}" class="btn-ghost" />
                </x-slot:actions>
            </x-card>

            <!-- Ações Rápidas -->
            <x-card title="Ações Rápidas" separator shadow>
                <div class="grid grid-cols-2 gap-3">
                    <x-button 
                        label="Novo Agendamento" 
                        icon="o-plus" 
                        {{-- link="{{ route('appointments.create') }}"  --}}
                        class="btn-primary" />
                    
                    <x-button 
                        label="Enviar Mensagem" 
                        icon="o-envelope" 
                        wire:click="showSendMessageModal" 
                        class="btn-outline" />
                    
                    <x-button 
                        label="Relatórios" 
                        icon="o-chart-bar" 
                        {{-- link="{{ route('reports') }}"  --}}
                        class="btn-outline" />
                    
                    <x-button 
                        label="Configurações" 
                        icon="o-cog-6-tooth" 
                        {{-- link="{{ route('settings') }}"  --}}
                        class="btn-outline" />
                </div>
            </x-card>
        </div>
    </div>

    <!-- Scripts para o FullCalendar -->
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
        <style>
            .fc-event-dot {
                display: inline-block;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                margin-right: 5px;
            }
        </style>
    @endpush
</div>