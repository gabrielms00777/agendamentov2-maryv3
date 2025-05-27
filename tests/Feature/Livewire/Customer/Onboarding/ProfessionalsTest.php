<?php

namespace Tests\Feature\Livewire\Customer\Onboarding;

use App\Livewire\Customer\Onboarding\Professionals;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProfessionalsTest extends TestCase
{
    public function test_renders_successfully()
    {
        Livewire::test(Professionals::class)
            ->assertStatus(200);
    }
}
