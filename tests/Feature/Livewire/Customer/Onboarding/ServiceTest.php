<?php

namespace Tests\Feature\Livewire\Customer\Onboarding;

use App\Livewire\Customer\Onboarding\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(Service::class)
            ->assertStatus(200);
    }
}
