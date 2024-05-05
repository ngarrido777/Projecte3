<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcio extends Model {
    use HasFactory;

    protected $table = 'inscripcions';
    protected $primaryKey = 'ins_id';
    public $timestamps = false;

    protected $fillable = [
        'ins_par_id',
        'ins_data',
        'ins_dorsal',
        'ins_retirat',
        'ins_bea_id',
        'ins_ccc_id'
    ];

    public function participant() {
        return $this->belongsTo(Participant::class, 'ins_par_id');
    }

    public function beacon() {
        return $this->belongsTo(Beacon::class, 'ins_bea_id');
    }

    public function circuit_categoria() {
        return $this->belongsTo(Circuit_categoria::class, 'ins_ccc_id');
    }
}
