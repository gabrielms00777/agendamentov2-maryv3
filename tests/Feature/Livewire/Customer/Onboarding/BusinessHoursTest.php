<?php

namespace Tests\Feature\Livewire\Customer\Onboarding;

use App\Livewire\Customer\Onboarding\BusinessHours;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class BusinessHoursTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(BusinessHours::class)
            ->assertStatus(200);
    }
}
