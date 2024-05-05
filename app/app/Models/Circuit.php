<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuit extends Model
{
    use HasFactory;

    protected $table = 'circuits';
    protected $primaryKey = 'cir_id';
    public $timestamps = false;

    protected $fillable = [
        'cir_cur_id',
        'cir_num',
        'cir_distancia',
        'cir_nom',
        'cir_preu',
        'cir_temps_estimat'
    ];

    public function cursa() {
        return $this->belongsTo(Cursa::class, 'cir_cur_id');
    }
}
