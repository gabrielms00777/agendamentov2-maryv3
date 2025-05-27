<?php

namespace App\Services\WhatsApp;

use App\Services\WhatsApp\Drivers\EvolutionWhatsApp;
// use App\Services\WhatsApp\Drivers\TwilioWhatsApp;
// use App\Services\WhatsApp\Drivers\MockWhatsApp;
use InvalidArgumentException;

class WhatsAppServiceProvider
{
    public static function getDriver(?string $driver = null): WhatsAppService
    {
        $driver = $driver ?? config('whatsapp.default_driver');
        
        return match($driver) {
            'evolution' => app(EvolutionWhatsApp::class),
            // 'twilio' => app(TwilioWhatsApp::class),
            // 'mock' => app(MockWhatsApp::class),
            default => throw new InvalidArgumentException("Driver WhatsApp não suportado: {$driver}"),
        };
    }
}