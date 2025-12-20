<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransakcijaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'korisnik_id'=>$this->korisnik_id,
            'korisnik'=>$this->korisnik,
            'novcanik_id'=>$this->novcanik_id,
            'novcanik'=>$this->novcanik,
            'kategorija_id'=>$this->kategorija_id,
            'kategorija'=>$this->kategorija,
            'tip'=>$this->tip,
            'iznos'=>(float)$this->iznos,
            'datum'=>$this->datum ? $this->datum->format('Y-m-d') : null,
            'opis'=>$this->opis
        ];
    }
}
