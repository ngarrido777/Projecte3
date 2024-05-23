<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';
    protected $primaryKey = 'par_id';
    public $timestamps = false;

    protected $fillable = [
        'par_nif',
        'par_nom',
        'par_cognoms',
        'par_data_naixement',
        'par_telefon',
        'par_email',
        'par_es_federat',
        'par_num_federat',
    ];
}
