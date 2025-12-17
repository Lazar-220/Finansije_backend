<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategorija;
use App\Models\Novcanik;
use App\Models\Transakcija;
use App\Models\Transfer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Kategorija::factory(30)->create();
        Novcanik::factory(20)->create();
        Transakcija::factory(100)->create();
        Transfer::factory(50)->create();


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
