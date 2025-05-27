<?php

namespace App\Livewire\Customer\Onboarding;

use Livewire\Attributes\On;
use Livewire\Component;

class BusinessHours extends Component
{
    public $businessHours = [];
    public $workingDays = [];
    
    public $weekdays = [
        'Segunda-feira', 'Terça-feira', 'Quarta-feira',
        'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'
    ];

    public function mount()
    {
        // Inicializa com todos os dias como trabalhados
        foreach ($this->weekdays as $day) {
            $this->workingDays[$day] = true;
            $this->businessHours[$day] = [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '13:00', 'end' => '18:00']
            ];
        }

        // dd($this->businessHours, $this->workingDays);
    }

    public function toggleWorkingDay($day)
    {
        $this->workingDays[$day] = !$this->workingDays[$day];
        
        // Se marcou como dia de trabalho e não tem horários, adiciona padrão
        if ($this->workingDays[$day] && empty($this->businessHours[$day])) {
            $this->businessHours[$day] = [
                ['start' => '08:00', 'end' => '12:00'],
                ['start' => '13:00', 'end' => '18:00']
            ];
        }
    }

    public function addTimeBlock($day)
    {
        $this->businessHours[$day][] = ['start' => '08:00', 'end' => '12:00'];
    }

    public function removeTimeBlock($day, $index)
    {
        if (count($this->businessHours[$day]) > 1) {
            unset($this->businessHours[$day][$index]);
            $this->businessHours[$day] = array_values($this->businessHours[$day]);
        }
    }

    #[On('requestStepValidation')]
    public function validateAndSend()
    {
        $this->validate([
            'workingDays' => 'required|array',
            'workingDays.*' => 'boolean',
            'businessHours' => 'required|array',
            'businessHours.*' => 'array',
            'businessHours.*.*.start' => [
                'required_with:businessHours.*',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    $parts = explode('.', $attribute);
                    $day = $parts[1];
                    
                    if ($this->workingDays[$day] && empty($value)) {
                        $fail("O horário de início é obrigatório para dias de trabalho.");
                    }
                }
            ],
            'businessHours.*.*.end' => [
                'required_with:businessHours.*.*.start',
                'date_format:H:i',
                'after:businessHours.*.*.start'
            ]
        ]);

        // Filtra apenas os dias trabalhados
        $filteredHours = [];
        foreach ($this->businessHours as $day => $blocks) {
            if ($this->workingDays[$day]) {
                $filteredHours[$day] = $blocks;
            }
        }

        $this->dispatch('requestStepData', 
            step: 3, 
            data: $filteredHours
        )->to(Manager::class);
    }
    
    public function render()
    {
        return view('livewire.customer.onboarding.business-hours');
    }
}
