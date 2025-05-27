<?php

namespace App\Livewire\Customer\Onboarding;

use App\Services\WhatsAppService;
use Livewire\Component;
use Mary\Traits\Toast;

class Whatsapp extends Component
{
    use Toast;

    public $phone = '16981294778';
    public $verificationCode = '';
    public $verificationCodeSent = '';
    public $verificationCodeShow = false;
    public $isVerified = false;
    public $qrCode = '';

    protected $rules = [
        'phone' => 'required|string|min:14',
        'verificationCode' => 'required_if:isVerified,false|digits:6'
    ];

    public function mount()
    {
        // Formatar para o padrão brasileiro se vazio
        if (empty($this->phone)) {
            $this->phone = '(  )     -    ';
        }
    }

    public function updatedPhone($value)
    {
        // Formatação automática do telefone
        $this->phone = $this->formatPhoneNumber($value);
    }

    public function sendVerification()
    {
        $this->validate(['phone' => 'required|string|min:14']);
        $this->verificationCodeSent = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->verificationCodeShow = true;
        $whatsAppService = new WhatsAppService();
        $whatsAppService->sendText('55'.preg_replace('/\D/', '', $this->phone), 'Seu codigo de verificação e: ' . $this->verificationCodeSent);

        $this->success('Codigo de verificação enviado com sucesso!');
    }

    public function verifyCode()
    {
        $this->validate(['verificationCode' => 'required|digits:6']);

        // Simulação de verificação (substituir por chamada real à API)
        if ($this->verificationCode === $this->verificationCodeSent) { // Código fixo para demonstração
            $this->isVerified = true;
            // $this->qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=WHATSAPP_VERIFICATION_TOKEN';
            $this->success('Número verificado com sucesso!');
        } else {
            $this->addError('verificationCode', 'Código inválido. Tente novamente.');
        }
    }

    private function formatPhoneNumber($value)
    {
        // Remove tudo que não é dígito
        $digits = preg_replace('/\D/', '', $value);

        // Aplica a máscara: (99) 99999-9999
        if (strlen($digits) <= 2) {
            return '(' . $digits;
        } elseif (strlen($digits) <= 6) {
            return '(' . substr($digits, 0, 2) . ') ' . substr($digits, 2);
        } elseif (strlen($digits) <= 10) {
            return '(' . substr($digits, 0, 2) . ') ' . substr($digits, 2, 4) . '-' . substr($digits, 6);
        } else {
            return '(' . substr($digits, 0, 2) . ') ' . substr($digits, 2, 5) . '-' . substr($digits, 7, 4);
        }
    }

    public function render()
    {
        return view('livewire.customer.onboarding.whatsapp');
    }
}
