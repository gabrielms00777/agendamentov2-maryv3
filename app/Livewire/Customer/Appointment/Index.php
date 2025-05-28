<?php

namespace App\Livewire\Customer\Appointment;

use App\Enums\AppointmentStatusEnum;
use App\Models\Appointment;
use App\Models\Professional;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
        use Toast, WithPagination;

    // Filtros e busca
    public string $search = '';
    public array $filters = [
        'status' => null,
        'service' => null,
        'professional' => null,
        'date_range' => null,
    ];

    // Modal e Drawer
    public bool $showModal = false;
    public bool $showDrawer = false;
    public $currentAppointment = null;

    // Ordenação
    public array $sortBy = ['column' => 'date', 'direction' => 'desc'];

    // Paginação
    public int $perPage = 10;
    public array $perPageOptions = [5, 10, 25, 50];

    protected function getAppointments()
    {
        return Appointment::query()
            ->with(['service', 'professional', 'company'])
            ->when($this->search, function ($query) {
                $query->where('client_name', 'like', "%{$this->search}%")
                    ->orWhere('client_phone', 'like', "%{$this->search}%");
            })
            ->when($this->filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($this->filters['service'], function ($query, $serviceId) {
                $query->where('service_id', $serviceId);
            })
            ->when($this->filters['professional'], function ($query, $professionalId) {
                $query->where('professional_id', $professionalId);
            })
            ->when($this->filters['date_range'], function ($query, $range) {
                if ($range === 'today') {
                    $query->whereDate('date', today());
                } elseif ($range === 'week') {
                    $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($range === 'month') {
                    $query->whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()]);
                }
            })
            ->orderBy(...array_values($this->sortBy))
            ->paginate($this->perPage);
    }

    public function edit(Appointment $appointment)
    {
        $this->currentAppointment = $appointment;
        $this->showModal = true;
    }

    public function create()
    {
        $this->currentAppointment = null;
        $this->showModal = true;
    }

    public function save()
    {
        // Lógica para salvar o agendamento
        $this->success('Agendamento salvo com sucesso!');
        $this->showModal = false;
    }

    public function delete(Appointment $appointment)
    {
        $appointment->delete();
        $this->success('Agendamento excluído!');
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }


    public function render()
    {
        return view('livewire.customer.appointment.index', [
            'appointments' => $this->getAppointments(),
            'services' => Service::all(),
            'professionals' => Professional::all(),
            'statusOptions' => AppointmentStatusEnum::cases(),
        ]);
    }
}
