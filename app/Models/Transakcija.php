<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Transakcija extends Model
{
    use HasFactory;

    protected $table = 'transakcije';
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

    public function korisnik(){
        return $this->belongsTo(User::class,'korisnik_id');
    }
    public function novcanik(){
        return $this->belongsTo(Novcanik::class,'novcanik_id');
    }
    public function kategorija(){
        return $this->belongsTo(Kategorija::class,'kategorija_id');
    }
}
