<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'korisnik_id',
        'novcanik_iz_id',
        'novcanik_u_id',
        'iznos',
        'valuta',
        'provizija',
        'datum',
        'opis'

        //cilj_id
    ];
    protected $casts = [
        'iznos'=>'decimal:2',
        'provizija'=>'decimal:2',
        'datum'=>'date'
    ];
}
