<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estat_cursa extends Model
{
    use HasFactory;

    protected $table = 'estats_cursa';
    protected $primaryKey = 'est_id';
    public $timestamps = false;

    protected $fillable = [
        'est_nom',
    ];
}
