<div>
    <x-header title="Configurações" separator />

    <x-tabs wire:model="selectedTab" class="mb-6">
        @foreach($tabs as $key => $tab)
            <x-tab name="{{ $key }}" label="{{ $tab['label'] }}" icon="{{ $tab['icon'] }}" />
        @endforeach
    </x-tabs>

    <div class="space-y-6">
        <!-- Tab Empresa -->
        @if($selectedTab === 'company')
            <x-card title="Dados da Empresa" separator>
                <x-form wire:submit="saveCompany">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-input label="Nome" wire:model="name" icon="o-building-office" />
                        <x-input label="E-mail" wire:model="email" icon="o-envelope" />
                        <x-input label="Telefone" wire:model="phone" icon="o-phone" mask="(##) #####-####" />
                        <x-input label="Endereço" wire:model="address" icon="o-map-pin" />
                        <div class="md:col-span-2">
                            <x-file label="Logo" wire:model="logo" accept="image/*" />
                            @if($company->logo_url)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Logo atual:</p>
                                    <img src="{{ $company->logo_url }}" class="h-16 mt-1" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <x-slot:actions>
                        <x-button label="Salvar" type="submit" icon="o-check" class="btn-primary" spinner />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif

        <!-- Tab Usuários -->
        @if($selectedTab === 'users')
            <x-card title="Usuários" separator>
                <x-form wire:submit="createUser" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <x-input label="Nome" wire:model="newUser.name" icon="o-user" />
                        <x-input label="E-mail" wire:model="newUser.email" icon="o-envelope" />
                        <x-select 
                            label="Função" 
                            wire:model="newUser.role" 
                            :options="$roles" 
                            icon="o-shield-check" />
                        <x-input 
                            label="Senha" 
                            wire:model="newUser.password" 
                            type="password" 
                            icon="o-key" />
                    </div>

                    <x-slot:actions>
                        <x-button label="Adicionar Usuário" type="submit" icon="o-plus" class="btn-primary" spinner />
                    </x-slot:actions>
                </x-form>

                <x-table :headers="[
                    ['key' => 'name', 'label' => 'Nome'],
                    ['key' => 'email', 'label' => 'E-mail'],
                    ['key' => 'role', 'label' => 'Função'],
                ]" :rows="$users">
                    @scope('cell_role', $user)
                        <x-badge :value="$roles[$user->role]" class="badge-{{ $user->role === 'admin' ? 'primary' : 'neutral' }}" />
                    @endscope

                    @scope('actions', $user)
                        @if($user->id !== auth()->id())
                            <x-button icon="o-trash" wire:click="deleteUser({{ $user->id }})" spinner class="btn-ghost btn-sm text-error" />
                        @endif
                    @endscope
                </x-table>
            </x-card>
        @endif

        <!-- Tab WhatsApp -->
        @if($selectedTab === 'whatsapp')
            <x-card title="Configurações do WhatsApp" separator>
                <div class="space-y-6">
                    <x-alert icon="o-information-circle" title="Integração WhatsApp">
                        Conecte seu número para enviar e receber mensagens automaticamente
                    </x-alert>

                    <livewire:whatsapp-integration />
                </div>
            </x-card>
        @endif

        <!-- Tab Permissões -->
        @if($selectedTab === 'permissions')
            <x-card title="Gerenciamento de Permissões" separator>
                <div class="space-y-4">
                    <x-alert icon="o-shield-exclamation" title="Atenção" class="alert-warning">
                        Alterações nas permissões afetam imediatamente o acesso dos usuários
                    </x-alert>

                    <livewire:permissions-manager />
                </div>
            </x-card>
        @endif
    </div>
</div>