<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kategorija>
 */
class KategorijaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tip=$this->faker->randomElement(['priliv','odliv']);
        $prilivi=['Plata','Hobi','Freelance','Poklon','Stipendija'];
        $odlivi=['Hrana','Prevoz','Kirija','Racuni','Izlasci','Odeca'];
        
        $korisnici=User::all()->pluck('id')->toArray();
        return [
            // 'korisnik_id'=>User::factory();  //kreira korisnika i njega spaja sa kategorijom
            'korisnik_id'=>$this->faker->randomElement($korisnici),  //od postojecih korisnika uzmi nekog
            'naziv'=> $tip==='priliv' ? 
                    $this->faker->randomElement($prilivi) :
                    $this->faker->randomElement($odlivi),
            'tip'=>$tip,
            'roditelj_id'=>null,
            'boja'=>$this->faker->hexColor(),
            'ikonica'=>null,
            'aktivna'=>true
        ];
    }
}
