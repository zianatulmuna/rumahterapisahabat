<?php

namespace App\Models;

use App\Models\RekamTerapi;
use App\Models\SubRekamMedis;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Terapis extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'web';
    protected $table = 'terapis';    
    // protected $with = ['jadwal', 'rekam_medis', 'rekam_terapi'];
    protected $guarded = [];
    protected $primaryKey = 'id_terapis';
    public $incrementing = false;

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_terapis');
    }

    public function rekamTerapi()
    {
        return $this->belongsToMany(RekamTerapi::class, 'id_terapis');
    }

    public function jadwal()
    {
        return $this->belongsToMany(Jadwal::class, 'id_terapis');
    }
    
    public function getRouteKeyName(): string
    {
        return 'username';
    }

    public function scopeFilter($query, array $filters)
    {        
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        });

        $query->when($filters['tingkatan'] ?? false, function ($query, $tingkatan) {
            return $query->where('tingkatan', $tingkatan);
        });
    }

    public function scopeTerapisByPenyakit($query, $penyakit)
    {
        return $query->whereHas('subRekamMedis', function ($query) use ($penyakit) {
            $query->where('penyakit', $penyakit);                            
        })->orderBy('nama', 'ASC')->get();
    }
}
