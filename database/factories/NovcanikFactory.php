<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Novcanik>
 */
class NovcanikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $korisnici=User::all()->pluck('id')->toArray();
        return [
            'korisnik_id'=>$this->faker->randomElement($korisnici),
            'naziv'=>$this->faker->randomElement(['RSD banka','EUR banka','Kes','Stednja sef','Kripto 1','Kripto 2']),
            'tip'=>fake()->randomElement(['banka','kes','stednja','kripto','ostalo']),
            'valuta'=>fake()->randomElement(['RSD','USD','EUR']),
            'pocetno_stanje'=>fake()->randomFloat(2,0,10000),
            'trenutno_stanje'=>fake()->randomFloat(2,0,10000), //broj od 0 do 10000, sa 2 decimale
            'aktivan'=>fake()->boolean(90), //90% true
        ];
    }
}
