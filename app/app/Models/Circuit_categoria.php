<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuit_categoria extends Model
{
    use HasFactory;

    protected $table = 'circuits_categories';
    protected $primaryKey = 'ccc_id';
    public $timestamps = false;

    protected $fillable = [
        'ccc_cat_id',
        'ccc_cir_id'
    ];

    public function circuit() {
        return $this->belongsTo(Circuit::class, 'ccc_cir_id');
    }

    public function categoria() {
        return $this->belongsTo(Categoria::class, 'ccc_cat_id');
    }
}
