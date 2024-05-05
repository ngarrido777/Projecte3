<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'cat_id';
    public $timestamps = false;

    protected $fillable = [
        'cat_esp_id',
        'cat_nom'
    ];

    public function esport() {
        return $this->belongsTo(Esport::class, 'cat_esp_id');
    }
}
