<?php

namespace App\Livewire\Customer\Onboarding;

use Livewire\Component;

class Index extends Component
{
    public $currentStep = 1;

    public function teste()
    {
        dd('teste');
    }
    
    public function render()
    {
        return view('livewire.customer.onboarding.index');
    }
}
