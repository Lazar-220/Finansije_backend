<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novcanik extends Model
{
    protected $table = 'novcanici';
    
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

    public function korisnik(){
        return $this->belongsTo(User::class,'korisnik_id');
    }

    public function transakcije(){
        return $this->hasMany(Transakcija::class,'novcanik_id');
    }

    public function transferiIz(){
        return $this->hasMany(Transfer::class,'novcanik_iz_id');
    }

    public function transferiU(){
        return $this->hasMany(Transfer::class,'novcanik_u_id');
    }
    

}
