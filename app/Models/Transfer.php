<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Transfer extends Model
{
    use HasFactory;

    protected $table='transferi';
    protected $fillable = [
        'korisnik_id',
        'novcanik_iz_id',
        'novcanik_u_id',
        'iznos',
        'valuta',
        'provizija',
        'datum',
        'opis'

    ];
    protected $casts = [
        'iznos'=>'decimal:2',
        'provizija'=>'decimal:2',
        'datum'=>'date'
    ];

    public function korisnik(){
        return $this->belongsTo(User::class,'korisnik_id');
    }
    public function novcanikIz(){
        return $this->belongsTo(Novcanik::class,'novcanik_iz_id');
    }
    public function novcanikU(){
        return $this->belongsTo(Novcanik::class,'novcanik_u_id');
    }
}
