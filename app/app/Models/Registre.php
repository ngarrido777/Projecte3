<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registre extends Model
{
    use HasFactory;

    protected $table = 'registres';
    protected $primaryKey = 'reg_id';
    public $timestamps = false;

    protected $fillable = [
        'reg_ins_id',
        'reg_chk_id',
        'reg_temps'
    ];

    public function inscripcio() {
        return $this->belongsTo(Inscripcio::class, 'reg_ins_id');
    }

    public function checkpoint() {
        return $this->belongsTo(Checkpoint::class, 'reg_chk_id');
    }
}
