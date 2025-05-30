<?php

namespace App\Livewire\Customer\Whatsapp;

use App\Models\WhatsappNumber;
use App\Services\WhatsAppService;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    public $chips = [];
    public $newChip = [
        'name' => '',
        'phone_number' => '',
    ];

    public function mount()
    {
        $this->loadChips();
    }

    public function loadChips()
    {
        $this->chips = WhatsappNumber::where('company_id', auth()->user()->company_id)->get();
    }

    public function addChip()
    {
        $validated = $this->validate([
            'newChip.name' => 'required|min:3',
            'newChip.phone_number' => 'required|min:14',
        ]);

        $whatsapp = new WhatsAppService();
        $result = $whatsapp->registerNumber(
            $validated['newChip']['phone_number'],
            auth()->user()->company_id
        );

        if ($result['success']) {
            WhatsappNumber::create([
                'company_id' => auth()->user()->company_id,
                'name' => $validated['newChip']['name'],
                'phone_number' => $validated['newChip']['phone_number'],
                'token' => $result['token'],
                'connected' => false,
            ]);

            $this->reset('newChip');
            $this->loadChips();
            $this->success('Número adicionado! Conecte-o escaneando o QR Code.');
        } else {
            $this->error('Falha ao registrar número: ' . $result['message']);
        }
    }

    public function connectChip($chipId)
    {
        // $chip = WhatsappNumber::find($chipId);
        // $whatsapp = new WhatsAppService($chip->token);
        // $qrCode = $whatsapp->getQrCode();

        // $this->dispatch('show-qrcode', qrcode: $qrCode, chipId: $chipId);
    }

    public function render()
    {
        return view('livewire.customer.whatsapp.index');
    }
}
