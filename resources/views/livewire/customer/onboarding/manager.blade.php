<div class="max-w-4xl mx-auto p-6">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Bem-vindo ao Sistema de Agendamento!</h1>
        <p class="text-gray-600">Vamos configurar seu sistema em poucos passos</p>
        
        {{-- Progress Steps --}}
        <div class="steps steps-horizontal w-full mt-8">
            <div class="step @if($currentStep >= 1) step-primary @endif">1</div>
            <div class="step @if($currentStep >= 2) step-primary @endif">2</div>
            <div class="step @if($currentStep >= 3) step-primary @endif">3</div>
            <div class="step @if($currentStep >= 4) step-primary @endif">4</div>
        </div>
    </div>

    {{-- Step Content --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        @if($currentStep == 1)
            {{-- Passo 1: Serviços --}}
            <livewire:customer.onboarding.services />
        @elseif($currentStep == 2)
            {{-- Passo 2: Profissionais --}}
            <livewire:customer.onboarding.professionals :$services />
        @elseif($currentStep == 3)
            {{-- Passo 3: Horários --}}
            <livewire:customer.onboarding.business-hours />
        @elseif($currentStep == 4)
            {{-- Passo 4: WhatsApp --}}
            <livewire:customer.onboarding.whatsapp />
        @endif
    </div>

    {{-- Navigation Buttons --}}
    <div class="flex justify-between mt-6">
        @if($currentStep > 1)
            <x-button label="Voltar" wire:click="previousStep" icon="o-arrow-left" class="btn-ghost" />
        @else
            <div></div> {{-- Empty div for spacing --}}
        @endif
        
        @if($currentStep < 4)
            <x-button label="Próximo" wire:click="triggerStepValidation" spinner icon-right="o-arrow-right" class="btn-primary" />
        @else
            <x-button label="Finalizar Configuração" wire:click="completeOnboarding" icon="o-check" class="btn-success" />
        @endif
    </div>
</div>