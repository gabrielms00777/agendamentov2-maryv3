<?php

namespace Tests\Feature\Livewire\Customer;

use App\Livewire\Customer\Onboarding;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class OnboardingTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(Onboarding::class)
            ->assertStatus(200);
    }
}
