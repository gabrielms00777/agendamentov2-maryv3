<?php

namespace App\Services\WhatsApp\Actions;

use App\Services\WhatsApp\WhatsAppServiceProvider;

class SendTextAction implements WhatsAppAction
{
    public function execute(array $data): array
    {
        $whatsapp = WhatsAppServiceProvider::getDriver($data['driver'] ?? null);
        
        return $whatsapp->sendText(
            $data['to'],
            $data['text']
        );
    }
}