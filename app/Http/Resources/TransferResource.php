<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferResource extends JsonResource
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
            'novcanik_iz_id'=>$this->novcanik_iz_id,
            'novcanikIz'=>$this->novcanikIz,
            'novcanik_u_id'=>$this->novcanik_u_id,
            'novcanikU'=>$this->novcanikU,
            'iznos'=>(float)$this->iznos,
            'valuta'=>$this->valuta,
            'provizija'=>$this->provizija!==null ? (float)$this->provizija : null,
            'datum'=>$this->datum!==null ? $this->datum->format('Y-m-d') : null,
            'opis'=>$this->opis
        ];
    }
}
