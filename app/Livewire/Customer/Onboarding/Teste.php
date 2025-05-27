<?php

namespace App\Livewire\Customer\Onboarding;

use Livewire\Component;

class Teste extends Component
{
    public $currentStep = 1;
    
    public function teste()
    {
        dd('teste');
    }
    public function render()
    {
        return view('livewire.customer.onboarding.teste');
    }
}
