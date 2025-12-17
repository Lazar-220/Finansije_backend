<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategorija;
use App\Models\Novcanik;
use App\Models\Transakcija;
use App\Models\Transfer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //ovo sluzi da obriseo stare podatke prilikom kreiranja novih
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //ova linija je da se iskljuci provera FK
        Transfer::truncate();
        Transakcija::truncate();
        Novcanik::truncate();
        Kategorija::truncate();
        User::truncate();


        User::factory(10)->create();
        Kategorija::factory(30)->create();
        Novcanik::factory(20)->create();
        Transakcija::factory(100)->create();
        Transfer::factory(50)->create();


        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
