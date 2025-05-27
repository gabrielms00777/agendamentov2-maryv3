<?php

return [
    'default_provider' => env('WHATSAPP_DRIVER', 'evolution'),
    
    'evolution' => [
        'base_url' => env('WHATSAPP_EVOLUTION_URL'),
        'api_key' => env('WHATSAPP_EVOLUTION_API_KEY'),
        'instance_name' => env('WHATSAPP_EVOLUTION_INSTANCE_NAME'),
    ],
    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from_number' => env('TWILIO_WHATSAPP_FROM'),
    ],
];