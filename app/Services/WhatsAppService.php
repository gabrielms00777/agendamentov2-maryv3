<?php

namespace App\Services;

use App\Services\WhatsApp\EvolutionApi;
use App\Services\WhatsApp\TwilioApi;
use InvalidArgumentException;

class WhatsAppService
{
    protected $provider;

    public function __construct(?string $provider = null)
    {
        $provider = $provider ?? config('whatsapp.default_provider');
        
        $this->provider = match($provider) {
            'evolution' => new EvolutionApi(),
            // 'twilio' => new TwilioApi(),
            default => throw new InvalidArgumentException("Provedor WhatsApp não suportado: {$provider}"),
        };
    }

    public function sendText(string $to, string $message, ?string $provider = null): array
    {
        if ($provider) {
            $this->setProvider($provider);
        }
        
        return $this->provider->sendText($to, $message);
    }

    public function sendList(string $to, array $listData, ?string $provider = null): array
    {
        if ($provider) {
            $this->setProvider($provider);
        }
        
        return $this->provider->sendList(
            $to, 
            $listData['title'],
            $listData['description'],
            $listData['button_text'],
            $listData['sections'],
            $listData['footer_text'],
            $listData['options']
        );
    }

    public function sendButtons(string $to, array $buttonsData, ?string $provider = null): array
    {
        if ($provider) {
            $this->setProvider($provider);
        }
        
        return $this->provider->sendButtons($to, $buttonsData);
    }

    protected function setProvider(string $provider): void
    {
        $this->provider = match($provider) {
            'evolution' => new EvolutionApi(),
            // 'twilio' => new TwilioApi(),
            default => throw new InvalidArgumentException("Provedor WhatsApp não suportado: {$provider}"),
        };
    }
}