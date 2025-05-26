<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\WhatsappMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatsappMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::all();
        foreach ($companies as $company) {
            WhatsappMessage::factory()
                ->count(20)
                ->for($company)
                ->create();
        }
    }
}
