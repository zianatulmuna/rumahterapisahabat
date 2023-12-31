<?php

namespace App\Models;

use App\Models\RekamMedis;
use App\Models\RekamTerapi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubRekamMedis extends Model
{
    use HasFactory;

    protected $table = 'sub_rekam_medis';
    protected $guarded = [];
    protected $primaryKey = 'id_sub';
    public $incrementing = false;


    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'id_rekam_medis');
    }

    public function rekamTerapi()
    {
        return $this->hasMany(RekamTerapi::class, 'id_sub');
    }
    
    public function terapis()
    {
        return $this->belongsToMany(Terapis::class, 'rekam_terapi', 'id_sub', 'id_terapis');
    }

    public function scopeFilter($query, $search, $sortBy, $idTerapis)
    {        
        $query->when($idTerapis ?? false, function ($query, $idTerapis) {
            return $query->whereHas('rekamMedis', function ($query) use ($idTerapis) {
                $query->where('is_private', 0)
                    ->orWhere('is_private', 1)
                    ->where('id_terapis', $idTerapis);
            });
        });

        $query->when($search ?? false, function ($query, $search) {
            return $query->where('penyakit', 'like', '%' . $search . '%');
        });

        $query->when($sortBy ?? false, function ($query, $sortBy) {
            return $query->orderBy('id_sub', $sortBy);
        });
    }
    public function scopePenyakitByTerapis($query, $idTerapis)
    {        
        return $query->whereHas('rekamTerapi', function ($query) use ($idTerapis) {
            $query->where('id_terapis', $idTerapis);
        })->distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');        
    }
}
