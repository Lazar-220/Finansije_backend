<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KategorijaResource extends JsonResource
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
            'naziv'=>$this->naziv,
            'tip'=>$this->tip,
            'roditelj_id'=>$this->roditelj_id,
            'roditelj'=>$this->roditelj,
            'boja'=>$this->boja,
            'ikonica'=>$this->ikonica,
            'aktivna'=>(boolean)$this->aktivna
        ];
    }
}
