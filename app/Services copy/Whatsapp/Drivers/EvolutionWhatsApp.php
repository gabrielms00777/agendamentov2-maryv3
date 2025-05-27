<?php

namespace App\Services\WhatsApp\Drivers;

use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionWhatsApp 
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $instanceName;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.drivers.evolution.base_url');
        $this->apiKey = config('whatsapp.drivers.evolution.api_key');
        $this->instanceName = config('whatsapp.drivers.evolution.instance_name');

        if (empty($this->baseUrl) || empty($this->apiKey)) {
            throw new \Exception("Configurações da Evolution API não encontradas no .env");
        }
    }

    protected function sendRequest(string $endpoint, array $data): array
    {
        if ($endpoint === 'message/sendList' && empty($data['sections'])) {
            throw new \Exception("Lista inválida: 'sections' é obrigatório");
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'apikey' => $this->apiKey,
            ])->post("{$this->baseUrl}/{$endpoint}/{$this->instanceName}", $data);

            if ($response->failed()) {
                throw new \Exception("Falha na API: " . $response->body());
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error("Evolution API Error: " . $e->getMessage(), [
                'endpoint' => $endpoint,
                'data' => $data
            ]);
            throw $e;
        }
    }

    public function sendText(string $number, string $text): array
    {
        return $this->sendRequest('message/sendText', [
            'number' => $this->formatNumber($number),
            'text' => $text,
        ]);
    }

    public function sendMedia(string $number, array $mediaData): array
    {
        return $this->sendRequest('message/sendMedia', [
            'number' => $this->formatNumber($number),
            'mediatype' => $mediaData['type'],
            'mimetype' => $mediaData['mime_type'],
            'caption' => $mediaData['caption'],
            'media' => $mediaData['url'],
            'fileName' => $mediaData['file_name'],
        ]);
    }

    public function sendList(
        string $to, 
        string $title, 
        string $description, 
        string $buttonText,
        array $sections,
        string $footerText = '',
        array $options = []
    ): array {
        return $this->sendRequest('message/sendList', array_merge([
            'number' => $this->formatNumber($to),
            'title' => $title,
            'description' => $description,
            'buttonText' => $buttonText,
            'footerText' => $footerText,
            'sections' => $sections
        ], $options));
    }

    public function sendButtons(
        string $to,
        string $title,
        string $description,
        array $buttons,
        string $footerText = ''
    ): array {
        return $this->sendRequest('message/sendButtons', [
            'number' => $this->formatNumber($to),
            'title' => $title,
            'description' => $description,
            'footerText' => $footerText,
            'buttons' => $buttons
        ]);
    }

    protected function formatNumber(string $number): string
    {
        $number = preg_replace('/\D/', '', $number);
        
        if (strlen($number) <= 11) {
            $number = '55' . $number; // Brasil como padrão
        }
        
        return $number;
        // return $number . '@c.us';
    }


    // public function sendMessage(string $to, string $message): array
    // {
    //     $response = Http::withHeaders([
    //         'apikey' => $this->apiKey,
    //     ])->post("{$this->baseUrl}/message/sendText/{$this->instanceName}", [
    //         'number' => $this->formatNumber($to),
    //         'textMessage' => ['text' => $message],
    //     ]);

    //     return $response->json();
    // }

    // public function sendVerificationCode(string $to): array
    // {
    //     // Gera um código de 6 dígitos
    //     $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
    //     // Envia o código via WhatsApp
    //     $this->sendMessage($to, "Seu código de verificação é: {$code}");
        
    //     return [
    //         'success' => true,
    //         'code' => $code, // Em produção, armazenar em cache com expiration
    //     ];
    // }

    // public function verifyNumber(string $to, string $code): bool
    // {
    //     // Em produção, verificar contra o código armazenado em cache
    //     return true; // Simplificado para exemplo
    // }

    // public function getQrCode(): string
    // {
    //     $response = Http::withHeaders([
    //         'apikey' => $this->apiKey,
    //     ])->get("{$this->baseUrl}/instance/qrbase64/{$this->instanceId}");

    //     return $response->json()['qr'] ?? '';
    // }

    // public function disconnect(): bool
    // {
    //     $response = Http::withHeaders([
    //         'apikey' => $this->apiKey,
    //     ])->delete("{$this->baseUrl}/instance/logout/{$this->instanceId}");

    //     return $response->successful();
    // }

    // public function getConnectionStatus(): string
    // {
    //     $response = Http::withHeaders([
    //         'apikey' => $this->apiKey,
    //     ])->get("{$this->baseUrl}/instance/connectionState/{$this->instanceId}");

    //     return $response->json()['state'] ?? 'disconnected';
    // }

    // protected function formatNumber(string $number): string
    // {
    //     // Remove tudo que não é dígito
    //     $number = preg_replace('/\D/', '', $number);
        
    //     // Adiciona código do país se necessário
    //     if (strlen($number) <= 11) {
    //         $number = '55' . $number; // Brasil como padrão
    //     }
        
    //     return $number . '@c.us';
    // }
}