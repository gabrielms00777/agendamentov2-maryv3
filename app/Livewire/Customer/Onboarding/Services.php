<?php

namespace App\Livewire\Customer\Onboarding;

use Livewire\Component;

class Services extends Component
{
    public $services = [
        ['name' => '', 'duration' => 30, 'price' => '']
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
    
    public function render()
    {
        return view('livewire.customer.onboarding.services');
    }
}
