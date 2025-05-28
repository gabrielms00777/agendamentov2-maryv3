<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Company;
use App\Models\Professional;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria uma empresa de exemplo
        $company = \App\Models\Company::factory()->create([
            'name' => 'Salão de Beleza',
            'email' => 'contato@salao.com',
            'phone' => '5511999999999',
        ]);

        // Cria serviços
        $services = \App\Models\Service::factory()->count(5)->create([
            'company_id' => $company->id
        ]);

        // Cria profissionais
        $professionals = \App\Models\Professional::factory()->count(3)->create([
            'company_id' => $company->id
        ]);

        // Cria chips WhatsApp
        \App\Models\WhatsappNumber::factory()->count(2)->create([
            'company_id' => $company->id,
            'status' => 'connected'
        ]);

        // Cria agendamentos para hoje
        \App\Models\Appointment::factory()->count(8)->create([
            'company_id' => $company->id,
            'service_id' => $services->random()->id,
            'professional_id' => $professionals->random()->id,
            'date' => now()->format('Y-m-d'),
            'status' => \Illuminate\Support\Arr::random(['scheduled', 'confirmed', 'completed'])
        ]);

        // Cria agendamentos futuros
        \App\Models\Appointment::factory()->count(15)->create([
            'company_id' => $company->id,
            'service_id' => $services->random()->id,
            'professional_id' => $professionals->random()->id,
            'date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
            'status' => 'scheduled'
        ]);


        // \App\Models\Service::factory(8)->create(['company_id' => 1]);
        // \App\Models\Professional::factory(5)->create(['company_id' => 1]);
        // \App\Models\Appointment::factory(50)->create(['company_id' => 1, 'service_id' => 1, 'professional_id' => 1]);


        User::factory()->create([
            'company_id' => $company->id,
            'name' => 'Admin',
            'email' => 'admin@admin',
            'password' => 'admin'
        ]);
    }
}
