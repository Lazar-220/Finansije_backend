<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NovcanikResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //sluzi nam da json kojim vracamo 1 ili vise novcanika mozemo da umotamo ovim nacinom zapisa
        return [
            'id'=>$this->id,
            'korisnik'=>$this->korisnik,  //preko fje korisnik dobijamo podatke, da je stajalo korisnik() dobili bismo relaciju (belongsTo)
            'naziv'=>$this->naziv,
            'tip'=>$this->tip,
            'valuta'=>$this->valuta,
            'pocetno_stanje'=>(float)$this->pocetno_stanje,
            'trenutno_stanje'=>(float)$this->trenutno_stanje,
            'aktivan'=>(boolean)$this->aktivan
        ];
    }
}
