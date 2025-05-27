<?php

namespace App\Services\WhatsApp;

interface WhatsAppService
{
    public function sendMessage(string $to, string $message): array;
    
    public function sendVerificationCode(string $to): array;
    
    public function verifyNumber(string $to, string $code): bool;
    
    public function getQrCode(): string;
    
    public function disconnect(): bool;
    
    public function getConnectionStatus(): string;
}