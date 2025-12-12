<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novcanik extends Model
{
    protected $fillable = [
        'korisnik_id',
        'naziv',
        'tip',
        'valuta',
        'pocetno_stanje',
        'trenutno_stanje',
        'aktivan'
    ];

    protected $casts = [
        'aktivan'=>'boolean',
        'pocetno_stanje'=>'decimal:2',
        'trenutno_stanje'=>'decimal:2'
    ];

}
