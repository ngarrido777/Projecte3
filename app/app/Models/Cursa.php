<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursa extends Model
{
    use HasFactory;

    protected $table = 'curses';
    protected $primaryKey = 'cur_id';
    public $timestamps = false;

    protected $fillable = [
        'cur_nom', 'cur_data_inici', 'cur_data_fi', 'cur_lloc', 'cur_esp_id', 'cur_est_id', 'cur_desc', 'cur_limit_inscr', 'cur_foto', 'cur_web',
    ];

    public function esports()
    {
        return $this->belongsTo(Esport::class, 'cur_esp_id');
    }

    public function estatCursa()
    {
        return $this->belongsTo(EstatCursa::class, 'cur_est_id');
    }
}
