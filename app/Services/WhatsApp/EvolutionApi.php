<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionApi
{
    protected $baseUrl;
    protected $apiKey;
    protected $instanceName;

    public function __construct()
    {
        $this->baseUrl = config('whatsapp.evolution.base_url');
        $this->apiKey = config('whatsapp.evolution.api_key');
        $this->instanceName = config('whatsapp.evolution.instance_name');

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

            return [
                'success' => true,
                'data' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error("Evolution API Error: " . $e->getMessage(), [
                'endpoint' => $endpoint,
                'data' => $data
            ]);
            return [
                'success' => false,
                'error' => 'Falha ao enviar mensagem',
                'details' => $e->getMessage(),
            ];
        }
    }

    public function sendText(string $number, string $text): array
    {
        return $this->sendRequest('message/sendText', [
            'number' => $number,
            'text' => $text,
        ]);
    }

    public function sendMedia(string $number, array $mediaData): array
    {
        return $this->sendRequest('message/sendMedia', [
            'number' => $number,
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
    ) {
        return $this->sendRequest('message/sendList', array_merge([
            'number' => $to,
            'title' => $title,
            'description' => $description,
            'buttonText' => $buttonText,
            'footerText' => $footerText,
            'sections' => $sections
        ], $options));
    }


    // public function sendText(string $to, string $message): array
    // {
    //     $number = $this->formatNumber($to);

    //     $response = Http::withHeaders([
    //         'apikey' => $this->apiKey,
    //     ])->post("{$this->baseUrl}/message/sendText/{$this->instanceName}", [
    //         'number' => $number,
    //         'textMessage' => ['text' => $message],
    //     ]);

    //     return $this->handleResponse($response);
    // }

    // public function sendList(string $to, array $listData): array
    // {
    //     $number = $this->formatNumber($to);

    //     $data = [
    //         'number' => $number,
    //         'title' => $listData['title'],
    //         'description' => $listData['description'],
    //         'buttonText' => $listData['button_text'],
    //         'sections' => $listData['sections'],
    //         'footerText' => $listData['footer'] ?? '',
    //     ];

    //     $response = Http::withHeaders([
    //         'apikey' => $this->apiKey,
    //     ])->post("{$this->baseUrl}/message/sendList/{$this->instanceName}", $data);

    //     return $this->handleResponse($response);
    // }

    public function sendButtons(string $to, array $buttonsData): array
    {
        $number = $this->formatNumber($to);

        $data = [
            'number' => $number,
            'title' => $buttonsData['title'],
            'description' => $buttonsData['description'],
            'footerText' => $buttonsData['footer'] ?? '',
            'buttons' => $buttonsData['buttons'],
        ];

        $response = Http::withHeaders([
            'apikey' => $this->apiKey,
        ])->post("{$this->baseUrl}/message/sendButtons/{$this->instanceName}", $data);

        return $this->handleResponse($response);
    }

    protected function formatNumber(string $number): string
    {
        $number = preg_replace('/\D/', '', $number);
        return '55' . $number; // Assume Brasil como padrão
        // return '55' . $number . '@c.us'; // Assume Brasil como padrão
    }

    protected function handleResponse($response): array
    {
        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $response->json(),
            ];
        }

        Log::error('Evolution API Error', [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        return [
            'success' => false,
            'error' => 'Falha ao enviar mensagem',
            'details' => $response->json(),
        ];
    }
}
