
<div>
    <!-- Cabeçalho -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="text-sm text-gray-500">
            Hoje é {{ now()->format('d/m/Y') }}
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-card class="bg-green-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 mr-4">
                    <x-icon name="o-calendar" class="w-6 h-6 text-green-600" />
                </div>
                <div>
                    <div class="text-gray-500">Agendamentos hoje</div>
                    <div class="text-2xl font-bold">{{ $todayStats['total'] }}</div>
                </div>
            </div>
        </x-card>

        <x-card class="bg-blue-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 mr-4">
                    <x-icon name="o-check-badge" class="w-6 h-6 text-blue-600" />
                </div>
                <div>
                    <div class="text-gray-500">Confirmados</div>
                    <div class="text-2xl font-bold">{{ $todayStats['confirmed'] }}</div>
                </div>
            </div>
        </x-card>

        <x-card class="bg-yellow-50">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 mr-4">
                    <x-icon name="o-clock" class="w-6 h-6 text-yellow-600" />
                </div>
                <div>
                    <div class="text-gray-500">Pendentes</div>
                    <div class="text-2xl font-bold">{{ $todayStats['pending'] }}</div>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Grid Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Próximos Agendamentos -->
        <div class="lg:col-span-2">
            <x-card>
                <x-slot:header>
                    <h2 class="text-lg font-semibold">Próximos Agendamentos</h2>
                    <x-button label="Ver todos" link="{{ route('app.appointments') }}" class="btn-ghost btn-sm" />
                </x-slot:header>

                @if($upcomingAppointments->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingAppointments as $appointment)
                        <div class="flex items-center p-3 border rounded-lg">
                            <div class="mr-4 text-center">
                                <div class="text-xs uppercase text-gray-500">{{ \Carbon\Carbon::parse($appointment->date)->format('D') }}</div>
                                <div class="text-2xl font-bold">{{ \Carbon\Carbon::parse($appointment->date)->format('d') }}</div>
                            </div>
                            <div class="flex-grow">
                                <div class="font-medium">{{ $appointment->client_name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $appointment->time }} • {{ $appointment->service->name }}
                                </div>
                            </div>
                            <div>
                                <x-badge :value="$appointment->status" @class([
                                    'badge-success' => $appointment->status === 'confirmed',
                                    'badge-warning' => $appointment->status === 'pending',
                                    'badge-error' => $appointment->status === 'cancelled',
                                ]) />
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <x-icon name="o-calendar" class="w-12 h-12 mx-auto text-gray-300" />
                        <p class="mt-2">Nenhum agendamento futuro</p>
                    </div>
                @endif
            </x-card>
        </div>

        <!-- Atividades Recentes -->
        <div>
            <x-card>
                <x-slot:header>
                    <h2 class="text-lg font-semibold">Atividades Recentes</h2>
                </x-slot:header>

                <div class="space-y-4">
                    @foreach($recentMessages as $message)
                    <div class="flex items-start">
                        <div class="mr-3 mt-1">
                            @if($message['type'] === 'whatsapp')
                                <x-icon name="o-chat-bubble-left-ellipsis" class="w-5 h-5 text-green-500" />
                            @else
                                <x-icon name="o-bell-alert" class="w-5 h-5 text-blue-500" />
                            @endif
                        </div>
                        <div>
                            <p class="font-medium">{{ $message['content'] }}</p>
                            <p class="text-xs text-gray-500">{{ $message['time'] }}</p>
                        </div>
                    </div>
                    @endforeach

                    <div class="pt-2">
                        <x-button label="Ver todas" icon="o-arrow-right" class="btn-ghost btn-sm" />
                    </div>
                </div>
            </x-card>

            <!-- Ações Rápidas -->
            <x-card class="mt-6">
                <x-slot:header>
                    <h2 class="text-lg font-semibold">Ações Rápidas</h2>
                </x-slot:header>

                <div class="grid grid-cols-2 gap-3">
                    <x-button label="Novo Agendamento" icon="o-plus" link="#" class="btn-primary" />
                    <x-button label="Enviar Mensagem" icon="o-envelope" link="#" class="btn-outline" />
                    <x-button label="Relatórios" icon="o-chart-bar" link="#" class="btn-outline" />
                    <x-button label="Configurações" icon="o-cog-6-tooth" link="#" class="btn-outline" />
                    {{-- <x-button label="Configurações" icon="o-cog-6-tooth" link="{{ route('settings') }}" class="btn-outline" /> --}}
                </div>
            </x-card>
        </div>
    </div>
</div>