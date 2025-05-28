<?php

namespace App\Livewire\Customer\Onboarding;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Services extends Component
{
    public $services = [
        ['name' => 'teste', 'duration_minutes' => 30, 'price' => '']
    ];

    public function mount()
    {
        $servces = Auth::user()->company->services;
        
        if(!empty($servces)) {
            $this->services = $servces->toArray();
        }

        // dd($servces);
    }

    public function addService()
    {
        $this->services[] = ['name' => '', 'duration_minutes' => 30, 'price' => ''];
    }

    public function removeService($index)
    {
        // dd($this->services[$index]);
        if(array_key_exists('id', $this->services[$index])) {
            Service::query()
            ->where('id', $this->services[$index]['id'])->delete();
        }
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    #[On('requestStepValidation')]
    public function validateAndSend()
    {
        $this->validate([
            'services' => 'required|array|min:1',
            'services.*.name' => 'required|string|min:3',
            'services.*.duration_minutes' => 'required|integer|min:15',
            'services.*.price' => 'nullable|numeric',
        ]);

        foreach ($this->services as $index => $service) {
            Service::query()->updateOrCreate([
                'name' => $service['name'],
            ], [
                'duration_minutes' => $service['duration_minutes'],
                'price' => $service['price'],
                'company_id' => Auth::user()->company->id
            ]);
            // $this->services[$index]['company_id'] = Auth::user()->company->id;
        }

        // Auth::user()->company->services()->insert($this->services);

        $this->dispatch('requestStepData', step: 1, data: $this->services)->to(Manager::class);
    }

    public function render()
    {
        return view('livewire.customer.onboarding.services');
    }
}
