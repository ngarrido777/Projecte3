<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
    use HasFactory;

    protected $table = 'beacons';
    protected $primaryKey = 'bea_id';
    public $timestamps = false;

    protected $fillable = [
        'bea_code'
    ];
}
