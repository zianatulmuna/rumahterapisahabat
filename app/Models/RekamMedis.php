<?php

namespace App\Models;

use App\Models\Pasien;
use App\Models\RekamTerapi;
use App\Models\SubRekamMedis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $guarded = [];
    protected $primaryKey = 'id_rekam_medis';
    public $incrementing = false;

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }
    public function subRekamMedis()
    {
        return $this->hasMany(SubRekamMedis::class, 'id_rekam_medis');
    }

    
    public function deployments()
    {
        return $this->hasManyThrough(
            Deployment::class,
            Environment::class,
            'project_id', // Foreign key on the environments table...
            'environment_id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'id' // Local key on the environments table...
        );
    }

    
    public function rekamTerapi()
    {
        return $this->hasManyThrough(
            RekamTerapi::class,
            SubRekamMedis::class,
            'id_rekam_medis', // Foreign key on the environments table...
            'id_sub', // Foreign key on the deployments table...
            'id_terapi', // Local key on the projects table...
            'id_sub' // Local key on the environments table...
        );
    }
    
}
