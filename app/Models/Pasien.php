<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\RekamMedis;
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

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_pasien');
    }

    public function subRekamMedis()
    {
        return $this->throughRekamMedis()->hasSubRekamMedis();
    }

    public function jadwal()
    {
        return $this->belongsToMany(Jadwal::class, 'id_pasien');
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

    public function scopeFilter($query, $search, $sortBy, $status)
    {
        $query->when($status == 'Selesai' ?? false, function ($query) {
            return $query->whereDoesntHave('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Rawat Jalan');
            });
        });

        $query->when($status == 'Jeda' ?? false, function ($query) {
            return $query->whereHas('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Jeda');
            });
        });

        $query->when($status == 'Rawat Jalan' ?? false, function ($query) {
            return $query->whereHas('rekamMedis', function ($query) {
                $query->where('status_pasien', 'Rawat Jalan');
            });
        });
        
        $query->when($search ?? false, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                         ->orWhere('id_pasien', 'like', '%' . $search . '%')
                         ->orWhereHas('rekamMedis', function ($query) use ($search) {
                            $query->where('penyakit', 'like', '%' . $search . '%')
                                    ->orWhere('id_rekam_medis', 'like', '%' . $search . '%');
                        });
        });

        $query->when($sortBy ?? false, function ($query, $sortBy) {
            return $query->orderBy('tanggal_pendaftaran', $sortBy);
        });
    }
    
    public function scopeDataMingguIni($query, $penyakit)
    {       
        $year = Carbon::now()->year;
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $query->selectRaw('tanggal_pendaftaran as tanggal, COUNT(*) as total')
            ->whereYear('tanggal_pendaftaran', $year)
            ->whereBetween('tanggal_pendaftaran', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_pendaftaran');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('rekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });
            
        return $query->get();
    }

    public function scopeDataBulanIni($query, $penyakit)
    {       
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $query->selectRaw('tanggal_pendaftaran as tanggal, COUNT(*) as total')
            ->whereBetween('tanggal_pendaftaran', [$startDate, $endDate])
            ->groupBy('tanggal_pendaftaran')
            ->orderBy('tanggal_pendaftaran');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('rekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });
            
        return $query->pluck('total', 'tanggal');
    }
    public function scopeDataPerTahun($query, $penyakit, $tahun)
    {  
        $query->selectRaw('MONTH(tanggal_pendaftaran) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pendaftaran', $tahun)->groupBy('bulan');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('rekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });
            
        return $query->get();
    }

    public function scopeDataSemuaTahun($query, $penyakit)
    {  
        $query->selectRaw('YEAR(tanggal_pendaftaran) as tahun, COUNT(*) as total')
            ->groupBy('tahun')->orderBy('tahun', 'ASC');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('rekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });
            
        return $query->get();
    }    
}
