<?php

namespace App\Livewire\Customer\Dashboard;

use App\Models\Appointment;
use App\Models\Professional;
use App\Models\WhatsappNumber;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    
    public $todayStats = [];
    public $upcomingAppointments = [];
    public $todaysAppointments = [];
    public $activeProfessionalsCount = 0;
    public $connectedChipsCount = 0;
    public $nextAppointment = null;

    public function mount()
    {
        $this->loadData();
    }

    protected function loadData()
    {
        $companyId = Auth::user()->company_id;

        // Estatísticas do dia
        $this->todayStats = [
            'total' => Appointment::where('company_id', $companyId)
                ->whereDate('date', today())
                ->count(),
            'confirmed' => Appointment::where('company_id', $companyId)
                ->whereDate('date', today())
                ->where('status', 'confirmed')
                ->count(),
            'pending' => Appointment::where('company_id', $companyId)
                ->whereDate('date', today())
                ->where('status', 'pending')
                ->count(),
        ];

        // Próximo agendamento
        $this->nextAppointment = Appointment::where('company_id', $companyId)
            ->where('date', '>=', now()->format('Y-m-d'))
            ->where('status', 'confirmed')
            ->orderBy('date')
            ->orderBy('time')
            ->first();

        // Agendamentos de hoje
        $this->todaysAppointments = Appointment::with(['service', 'professional'])
            ->where('company_id', $companyId)
            ->whereDate('date', today())
            ->orderBy('time')
            ->get();

        // Profissionais ativos
        $this->activeProfessionalsCount = Professional::where('company_id', $companyId)
            ->where('active', true)
            ->count();

        // Chips conectados
        $this->connectedChipsCount = WhatsappNumber::where('company_id', $companyId)
            ->where('status', 'connected')
            ->count();
    }

    public function render()
    {
        return view('livewire.customer.dashboard.index');
    }
}
