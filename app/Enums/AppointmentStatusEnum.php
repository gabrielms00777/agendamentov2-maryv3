<?php

namespace App\Enums;

enum AppointmentStatusEnum: string
{
    case PENDING = 'pending';
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::CONFIRMED => 'Confirmado',
            self::SCHEDULED => 'Agendado',
            self::CANCELED => 'Cancelado',
            self::COMPLETED => 'Concluído',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::CONFIRMED => 'badge-success',
            self::PENDING => 'badge-warning',
            self::CANCELED => 'badge-error',
            self::COMPLETED => 'badge-info',
        };
    }
}