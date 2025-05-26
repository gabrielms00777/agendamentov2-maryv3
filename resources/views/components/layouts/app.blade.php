<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="px-5 pt-4" />

            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User Info --}}
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="{{ $user->company->name }}" no-separator no-hover class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="Sair" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />
                @endif

                {{-- Menu Principal --}}
                <x-menu-item title="Dashboard" icon="o-chart-bar" link="/dashboard" />
                
                <x-menu-sub title="Agendamentos" icon="o-calendar">
                    <x-menu-item title="Novo Agendamento" icon="o-plus-circle" link="/appointments/create" />
                    <x-menu-item title="Lista de Agendamentos" icon="o-list-bullet" link="/appointments" />
                    <x-menu-item title="Bloquear Horários" icon="o-lock-closed" link="/blocked-slots" />
                </x-menu-sub>
                
                <x-menu-sub title="Configurações" icon="o-cog-6-tooth">
                    <x-menu-item title="Serviços" icon="o-scissors" link="/services" />
                    <x-menu-item title="Profissionais" icon="o-user-group" link="/professionals" />
                    <x-menu-item title="Horários de Funcionamento" icon="o-clock" link="/business-hours" />
                    <x-menu-item title="WhatsApp" icon="o-chat-bubble-left-ellipsis" link="/whatsapp-chips" />
                </x-menu-sub>
                
                @can('admin')
                <x-menu-sub title="Administração" icon="o-shield-check">
                    <x-menu-item title="Usuários" icon="o-users" link="/users" />
                    <x-menu-item title="Configurações da Empresa" icon="o-building-office" link="/company-settings" />
                </x-menu-sub>
                @endcan
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- TOAST area --}}
    <x-toast />
</body>
</html>