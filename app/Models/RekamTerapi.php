<?php

namespace App\Models;

use App\Models\Terapis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RekamTerapi extends Model
{
    use HasFactory;
    protected $table = 'rekam_terapi';
    protected $guarded = [];
    protected $primaryKey = 'id_terapi';
    public $incrementing = false;

    public $with = ['terapis'];

    // public function pasien()
    // {
    //     return $this->belongsTo(Pasien::class, 'id_pasien');
    // }
    public function scopeTotalTerapi($query, $id_terapis)
    {
        return $query->where('id_terapis', $id_terapis)->count();
    }
    public function scopeTotalTerapiSub($query, $id_sub)
    {
        return $query->where('id_sub', $id_sub)->count();
    }

    // public function getRouteKeyName(): string
    // {
    //     return 'tanggal';
    // }

    public function subRekamMedis()
    {
        return $this->belongsTo(SubRekamMedis::class, 'id_sub');
    }

    public function terapis()
    {
        return $this->belongsTo(Terapis::class, 'id_terapis');
    }
}
