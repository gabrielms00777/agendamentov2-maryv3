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
}