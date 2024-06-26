<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuari extends Model
{
    use HasFactory;
    
    protected $table = 'usuaris';
    protected $primaryKey = 'usr_id';
    public $timestamps = false;

    protected $fillable = [
        'usr_login',
        'usr_password',
        'usr_admin'
    ];
}
