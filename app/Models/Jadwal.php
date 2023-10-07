<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $guarded = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
    public function terapis()
    {
        return $this->belongsTo(Terapis::class, 'id_terapis');
    }
    public function subRekamMedis()
    {
        return $this->belongsTo(SubRekamMedis::class, 'id_sub');
    }
    
    public function getRouteKeyName(): string
    {
        return 'id_jadwal';
    }
}
