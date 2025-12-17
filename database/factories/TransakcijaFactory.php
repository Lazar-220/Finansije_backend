<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Novcanik;
use App\Models\Kategorija;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transakcija>
 */
class TransakcijaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $korisnici=User::all()->pluck('id')->toArray();
        $novcanici=Novcanik::all()->pluck('id')->toArray();
        $kategorije=Kategorija::all()->pluck('id')->toArray();
        
        return [
            'korisnik_id'=>$this->faker->randomElement($korisnici),
            'novcanik_id'=>$this->faker->randomElement($novcanici),
            'kategorija_id'=>$this->faker->randomElement($kategorije),
            'tip'=>$this->faker->randomElement(['priliv','odliv']),
            'iznos'=>$this->faker->randomFloat(2,100,30000),
            'datum'=>$this->faker->dateTimeBetween('-2 months','now')->format('Y-m-d'),
            'opis'=>$this->faker->optional()->sentence(3)
        ];
    }
}
