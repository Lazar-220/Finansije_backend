<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    protected $fillable = [
        'korisnik_id',
        'naziv',
        'tip',                 //priliv/odliv
        'roditelj_id',         //nullable (za podkategorije ako postoje)
        'boja',                //nullable
        'ikonica',             //nullable
        'aktivna'
    ];

    protected $casts = [
        'aktivna'=>'boolean'
    ];
}
