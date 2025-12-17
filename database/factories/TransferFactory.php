<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\User;
use App\Models\Novcanik;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
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

        $par=$this->faker->randomElements($novcanici,2);
        
        return [
            'korisnik_id'=>$this->faker->randomElement($korisnici),
            'novcanik_iz_id'=>$par[0],
            'novcanik_u_id'=>$par[1],
            'iznos'=>$this->faker->randomFloat(2,50,5000),
            'valuta'=>$this->faker->randomElement(['RSD','EUR']),
            'provizija'=>$this->faker->randomFloat(2,0,100),
            'datum'=>$this->faker->dateTimeBetween('-2 months','now')->format('Y-m-d'),
            'opis'=>$this->faker->optional()->sentence(3)
        
        ];
    }
}
