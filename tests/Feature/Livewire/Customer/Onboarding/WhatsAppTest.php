<?php

namespace Tests\Feature\Livewire\Customer\Onboarding;

use App\Livewire\Customer\Onboarding\WhatsApp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class WhatsAppTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(WhatsApp::class)
            ->assertStatus(200);
    }
}
