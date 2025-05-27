<?php

namespace App\Livewire\Customer\Onboarding;

use Livewire\Attributes\On;
use Livewire\Component;

class Services extends Component
{
    public $services = [
        ['name' => 'teste', 'duration' => 30, 'price' => '']
    ];

    public function addService()
    {
        $this->services[] = ['name' => '', 'duration' => 30, 'price' => ''];
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    #[On('requestStepValidation')]
    public function validateAndSend()
    {
        $this->validate([
            'services' => 'required|array|min:1',
            'services.*.name' => 'required|string|min:3',
            'services.*.duration' => 'required|integer|min:15',
            'services.*.price' => 'nullable|numeric',
        ]);

        $this->dispatch('requestStepData', step: 1, data: $this->services)->to(Manager::class);
    }

    public function render()
    {
        return view('livewire.customer.onboarding.services');
    }
}
