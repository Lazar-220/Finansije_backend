<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategorija extends Model
{
    protected $table = 'kategorije';
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

    public function korisnik(){
        return $this->belongsTo(User::class,'korisnik_id');
    }
    public function roditelj(){
        return $this->belongsTo(Kategorija::class,'roditelj_id');
    }
    public function transakcije(){
        return $this->hasMany(Transakcija::class,'kategorija_id');
    }
}
