<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    use HasFactory;

    protected $table = 'checkpoints';
    protected $primaryKey = 'chk_id';
    public $timestamps = false;

    protected $fillable = [
        'chk_cir_id',
        'chk_pk'
    ];

    public function circuit() {
        return $this->belongsTo(Circuit::class, 'chk_cir_id');
    }
}
