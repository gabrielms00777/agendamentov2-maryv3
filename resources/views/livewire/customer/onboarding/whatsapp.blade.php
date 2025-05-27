{{-- resources/views/livewire/onboarding/whatsapp-setup.blade.php --}}
<div>
    <h2 class="text-xl font-semibold mb-4">4. Conecte seu WhatsApp</h2>
    <p class="text-gray-600 mb-6">Vincule um número para receber agendamentos</p>
    
    <div class="bg-base-100 p-6 rounded-lg shadow-sm">
        @if(!$isVerified)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input 
                    label="Número do WhatsApp" 
                    wire:model="phone" 
                    placeholder="(99) 99999-9999" 
                    x-mask="(99) 99999-9999"
                    icon="o-phone" 
                />
                
                <x-button 
                    label="Enviar código de verificação" 
                    wire:click="sendVerification" 
                    icon="o-envelope" 
                    class="btn-primary mt-4" 
                    spinner
                />
                
                @if($verificationCodeShow)
                <div class="mt-6">
                    <x-input 
                        label="Código de verificação" 
                        wire:model="verificationCode" 
                        placeholder="Digite o código de 6 dígitos" 
                        maxlength="6"
                        icon="o-key" 
                    />
                    
                    <x-button 
                        label="Verificar número" 
                        wire:click="verifyCode" 
                        icon="o-check" 
                        class="btn-primary mt-4" 
                        spinner
                    />
                </div>
                @endif
            </div>
            
            <div class="flex items-center justify-center">
                <div class="text-center">
                    <x-icon name="o-qr-code" class="w-24 h-24 text-gray-300 mx-auto" />
                    <p class="text-gray-500 mt-2">Após verificação, escaneie o QR code</p>
                </div>
            </div>
        </div>
        @else
        <div class="text-center">
            <div class="mb-6">
                <p class="text-green-500 font-medium mb-2">
                    <x-icon name="o-check-badge" class="w-5 h-5 inline mr-1" />
                    Número verificado: {{ $phone }}
                </p>
                <p class="text-gray-600">Seu WhatsApp está pronto para receber agendamentos!</p>
            </div>
            
            <div class="border rounded-lg p-4 inline-block">
                <img src="{{ $qrCode }}" alt="QR Code para conexão" class="w-40 h-40 mx-auto">
                <p class="text-sm text-gray-500 mt-2">Escaneie este QR code no app do WhatsApp</p>
            </div>
            
            <div class="mt-6 text-left bg-blue-50 p-4 rounded-lg">
                <h4 class="font-medium mb-2">Dicas importantes:</h4>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Mantenha o celular com internet ativa</li>
                    <li>Não desative o número vinculado</li>
                    <li>O número será usado para enviar lembretes</li>
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>