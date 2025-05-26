<div class="md:w-96 mx-auto mt-10">
    <div class="mb-10">
        {{-- <x-app-brand /> --}}
        <h1 class="text-2xl font-bold text-center mt-4">Crie sua conta</h1>
        <p class="text-sm text-center text-gray-500 mt-2">Gerencie seus agendamentos via WhatsApp</p>
    </div>
 
    <x-form wire:submit="register">
        <!-- Dados da Empresa -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Informações da Empresa</h2>
            <x-input 
                label="Nome da Empresa" 
                placeholder="Ex: Salão da Maria" 
                wire:model="company_name" 
                icon="o-building-office" 
            />
            <x-input 
                label="Telefone da Empresa" 
                placeholder="(99) 99999-9999" 
                wire:model="company_phone" 
                icon="o-phone" 
            />
        </div>
        
        <!-- Dados do Administrador -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Seus Dados de Acesso</h2>
            <x-input 
                label="Seu Nome" 
                placeholder="Ex: Maria Silva" 
                wire:model="name" 
                icon="o-user" 
            />
            <x-input 
                label="Seu E-mail" 
                placeholder="Ex: maria@salao.com" 
                wire:model="email" 
                icon="o-envelope" 
            />
            <x-input 
                label="Senha" 
                placeholder="Mínimo 8 caracteres" 
                wire:model="password" 
                type="password" 
                icon="o-key" 
            />
            <x-input 
                label="Confirme a Senha" 
                placeholder="Digite novamente" 
                wire:model="password_confirmation" 
                type="password" 
                icon="o-key" 
            />
        </div>
 
        <x-slot:actions>
            <x-button 
                label="Já tem uma conta? Faça login" 
                class="btn-ghost" 
                link="/login" 
            />
            <x-button 
                label="Criar Conta" 
                type="submit" 
                icon="o-paper-airplane" 
                class="btn-primary" 
                spinner="register" 
            />
        </x-slot:actions>
    </x-form>
    
    @error('registration')
        <x-alert icon="o-exclamation-triangle" class="mt-4 alert-error">
            {{ $message }}
        </x-alert>
    @enderror
</div>