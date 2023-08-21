<?php

namespace App\Models;

use App\Models\RekamMedis;
use App\Models\SubRekamMedis;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pasien extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'pasien';
    protected $guarded = [];

    protected $with = ['rekamMedis'];
    protected $primaryKey = 'id_pasien';
    
    public $incrementing = false;

    public function scopeFilter($query, $search, $sortBy, $status)
    {
        $query->when($status == 'Selesai' ?? false, function ($query) {
            return $query->whereDoesntHave('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Rawat Jalan');
            });
        });

        $query->when($status == 'Rawat Jalan' ?? false, function ($query) {
            return $query->whereHas('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Rawat Jalan');
            });
        });
        
        $query->when($search ?? false, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                         ->orWhere('tanggal_pendaftaran', 'like', '%' . $search . '%');
        })->orWhereHas('rekamMedis', function ($query) use ($search) {
            $query->where('penyakit', 'like', '%' . $search . '%');
        });

        $query->when($sortBy ?? false, function ($query, $sortBy) {
            return $query->orderBy('tanggal_pendaftaran', $sortBy);
        });
    }
    
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_pasien');
    }

    public function jadwal()
    {
        return $this->belongsToMany(Jadwal::class, 'id_pasien');
    }

    public function subRekamMedis()
    {
        return $this->hasManyThrough(
            SubRekamMedis::class,
            RekamMedis::class,
            'id_pasien', // Foreign key on the environments table...
            'id_sub', // Foreign key on the deployments table...
            'id_pasien', // Local key on the projects table...
            'id_rekam_medis' // Local key on the environments table...
        );
    }
}
