<?php

namespace App\Livewire\Customer\Onboarding;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $currentStep = 1;
    
    // Dados coletados durante o onboarding
    public $services = [];
    public $professionals = [];
    public $businessHours = [];
    public $whatsappNumber = '';
    public $whatsappToken = '';
    
    public function mount()
    {
        // Se já completou o onboarding, redireciona
        if (Auth::user()->company->onboarding_completed) {
            return redirect()->route('dashboard');
        }
    }
    
    public function nextStep()
    {
        $this->validateCurrentStep();
        $this->currentStep++;
    }
    
    public function previousStep()
    {
        $this->currentStep--;
    }
    
    private function validateCurrentStep()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'services' => 'required|array|min:1',
                'services.*.name' => 'required|string|min:3',
                'services.*.duration' => 'required|integer|min:15',
                'services.*.price' => 'nullable|numeric',
            ]);
        }
        // Validações para outros passos...
    }
    
    public function completeOnboarding()
    {
        // Salvar todos os dados
        $company = Auth::user()->company;
        
        // Salvar serviços
        foreach ($this->services as $serviceData) {
            $company->services()->create($serviceData);
        }
        
        // Marcar onboarding como completo
        $company->update(['onboarding_completed' => true]);
        
        // Redirecionar para o dashboard
        return redirect()->route('dashboard')->with('success', 'Configuração inicial concluída com sucesso!');
    }
    
    public function render()
    {
        return view('livewire.customer.onboarding.index');
    }
}
