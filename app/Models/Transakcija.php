<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transakcija extends Model
{
    protected $fillable = [
        'korisnik_id',
        // za priliv/odliv
        'novcanik_id',
        'kategorija_id',

        //priliv|odliv|transfer
        'tip',
        'iznos',
        'datum',
        'opis',
    ];

    protected $casts = [
        'iznos'=>'decimal:2',
        'datum'=>'date'
    ];
}
