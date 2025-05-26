<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\WhatsappNumber;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatsappNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        foreach ($companies as $company) {
            WhatsappNumber::factory()
                ->count(2)
                ->for($company)
                ->create();
        }
    }
}
