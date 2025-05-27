<?php

namespace App\Services\WhatsApp\Actions;

interface WhatsAppAction
{
    public function execute(array $data): array;
}