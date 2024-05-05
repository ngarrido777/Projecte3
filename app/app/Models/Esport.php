<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Esport extends Model
{
    use HasFactory;

    protected $table = 'esports';
    protected $primaryKey = 'esp_id';
    public $timestamps = false;

    protected $fillable = [
        'esp_nom',
    ];
}
