<?php

namespace App\Livewire\Customer\Onboarding;

use Livewire\Attributes\On;
use Livewire\Component;

class Professionals extends Component
{
    public $professionals = [
        ['name' => 'Teste', 'services' => []]
    ];
    public $availableServices = [];

    public function mount($services)
    {
        $this->availableServices = collect($services)->mapWithKeys(function ($service) {
            return [$service['name'] => $service['name']];
        })->toArray();
    }

    public function addProfessional()
    {
        $this->professionals[] = ['name' => '', 'services' => []];
    }

    public function removeProfessional($index)
    {
        unset($this->professionals[$index]);
        $this->professionals = array_values($this->professionals);
    }

    #[On('requestStepValidation')]
    public function validateAndSend()
    {
        $this->validate([
                'professionals' => 'required|array|min:1',
                'professionals.*.name' => 'required|string|min:3',
                'professionals.*.services' => 'required|array|min:1',
            ]);

        $this->dispatch('requestStepData', step: 2, data: $this->professionals)->to(Manager::class);
    }
    
    public function render()
    {
        return view('livewire.customer.onboarding.professionals');
    }
}
