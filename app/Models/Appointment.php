<?php

namespace App\Models;

use App\Enums\AppointmentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /** @use HasFactory<\Database\Factories\AppointmentFactory> */
    use HasFactory;

    protected $guarded = [];

    public function casts()
    {
        return [
            'date' => 'datetime',
            'time' => 'datetime',
            'status' => AppointmentStatusEnum::class,
        ];
    }

    public function getStatusBadgeClass()
    {
        // return AppointmentStatusEnum::from($this->status)->badgeClass();
        return match ($this->status) {
            AppointmentStatusEnum::CONFIRMED->value => 'badge-success',
            AppointmentStatusEnum::PENDING->value => 'badge-warning',
            AppointmentStatusEnum::CANCELED->value => 'badge-error',
            AppointmentStatusEnum::COMPLETED->value => 'badge-info',
            default => 'badge-secondary',
        };
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
