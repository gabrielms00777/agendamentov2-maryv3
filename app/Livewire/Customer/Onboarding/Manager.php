<?php

namespace App\Livewire\Customer\Onboarding;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


class Manager extends Component
{
    public $currentStep = 4;
    public $completedSteps = [];

    // Dados coletados durante o onboarding
    public $services = [];
    public $professionals = [];
    public $businessHours = [];
    public $whatsappPhone = '';
    public $whatsappToken = '';

    // protected $listeners = ['goToNextStep' => 'nextStep'];

    public function mount()
    {
        if (Auth::user()->company->onboarding_completed) {
            return redirect()->route('dashboard');
        }
    }

    #[On('requestStepData')]
    public function receiveStepData($step, $data)
    {
        if ($step === 1) {
            $this->services = $data;
            $this->currentStep = 2;
        } else if ($step === 2) {
            $this->professionals = $data;
            $this->currentStep = 3;
        } else if ($step === 3) {
            $this->businessHours = $data;
            $this->currentStep = 4;
        }
    }

    public function triggerStepValidation()
    {
        if ($this->currentStep == 1) {
            $this->dispatch('requestStepValidation')->to(Services::class);
        } else if ($this->currentStep == 2) {
            $this->dispatch('requestStepValidation')->to(Professionals::class);
        } else if ($this->currentStep == 3) {
            $this->dispatch('requestStepValidation')->to(BusinessHours::class);
        }
    }

    public function nextStep()
    {
        if ($this->validateCurrentStep()) {
            $this->completedSteps[] = $this->currentStep;
            $this->currentStep++;

            // Se foi para o passo 4 (WhatsApp), gera um token
            if ($this->currentStep == 4 && empty($this->whatsappToken)) {
                $this->whatsappToken = \Illuminate\Support\Str::random(32);
            }
        }
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    // private function validateCurrentStep()
    // {
    //     if ($this->currentStep == 1) {
    //         $this->validate([
    //             'services' => 'required|array|min:1',
    //             'services.*.name' => 'required|string|min:3',
    //             'services.*.duration' => 'required|integer|min:15',
    //             'services.*.price' => 'nullable|numeric',
    //         ]);
    //         return true;
    //     } elseif ($this->currentStep == 2) {
    //         $this->validate([
    //             'professionals' => 'required|array|min:1',
    //             'professionals.*.name' => 'required|string|min:3',
    //             'professionals.*.services' => 'required|array|min:1',
    //         ]);
    //         return true;
    //     } elseif ($this->currentStep == 3) {
    //         $this->validate([
    //             'businessHours' => 'required|array|min:1',
    //             'businessHours.*' => 'required|array|min:1',
    //             'businessHours.*.*.start' => 'required|date_format:H:i',
    //             'businessHours.*.*.end' => 'required|date_format:H:i|after:businessHours.*.*.start',
    //         ]);
    //         return true;
    //     } elseif ($this->currentStep == 4) {
    //         $this->validate([
    //             'whatsappPhone' => 'required|string|min:14',
    //         ]);
    //         return true;
    //     }

    //     return false;
    // }

    public function completeOnboarding()
    {
        $this->validateCurrentStep();

        try {
            DB::transaction(function () {
                $company = Auth::user()->company;

                // Salvar serviços
                foreach ($this->services as $serviceData) {
                    $company->services()->create($serviceData);
                }

                // Salvar profissionais e seus serviços
                foreach ($this->professionals as $professionalData) {
                    $professional = $company->professionals()->create([
                        'name' => $professionalData['name']
                    ]);

                    // Relacionar serviços com o profissional
                    $serviceIds = Service::whereIn('name', $professionalData['services'])
                        ->where('company_id', $company->id)
                        ->pluck('id');

                    $professional->services()->sync($serviceIds);
                }

                // Salvar horários de funcionamento
                foreach ($this->businessHours as $day => $timeBlocks) {
                    foreach ($timeBlocks as $block) {
                        $company->businessHours()->create([
                            'weekday' => $day,
                            'start_time' => $block['start'],
                            'end_time' => $block['end']
                        ]);
                    }
                }

                // Salvar chip do WhatsApp
                if ($this->whatsappPhone) {
                    $company->whatsappChips()->create([
                        'name' => 'Principal',
                        'phone_number' => preg_replace('/\D/', '', $this->whatsappPhone),
                        'token' => $this->whatsappToken
                    ]);
                }

                // Marcar onboarding como completo
                $company->update(['onboarding_completed' => true]);
            });

            return redirect()->route('dashboard')->with('success', 'Configuração inicial concluída com sucesso!');
        } catch (\Exception $e) {
            $this->dispatch('notify', type: 'error', message: 'Erro ao salvar configurações: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.customer.onboarding.manager');
    }
}
