<div class="max-w-4xl mx-auto p-6">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Bem-vindo ao Sistema de Agendamento!</h1>
        <p class="text-gray-600">Vamos configurar seu sistema em poucos passos</p>

        <div class="steps steps-horizontal w-full mt-8">
            <div class="step @if($currentStep >= 1) step-primary @endif">1</div>
            <div class="step @if($currentStep >= 2) step-primary @endif">2</div>
            <div class="step @if($currentStep >= 3) step-primary @endif">3</div>
            <div class="step @if($currentStep >= 4) step-primary @endif">4</div>
        </div>
    </div>
    <button wire:click="teste">teste</button>
</div>