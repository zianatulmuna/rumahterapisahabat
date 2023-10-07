<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Terapis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RekamTerapi extends Model
{
    use HasFactory;
    protected $table = 'rekam_terapi';
    protected $guarded = [];
    protected $primaryKey = 'id_terapi';
    public $with = ['terapis'];
    public $incrementing = false;

    public function subRekamMedis()
    {
        return $this->belongsTo(SubRekamMedis::class, 'id_sub');
    }
    
    public function terapis()
    {
        return $this->belongsTo(Terapis::class, 'id_terapis');
    }

    public function scopeTotalTerapiSub($query, $id_sub)
    {
        return $query->where('id_sub', $id_sub)->count();
    }

    public function scopeDataMingguIni($query, $terapis, $penyakit)
    {     
        $year = Carbon::now()->year;
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $query->selectRaw('tanggal, COUNT(*) as total')
            ->whereYear('tanggal', $year)
            ->whereBetween('tanggal', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal');

        $query->when($terapis ?? false, function ($query, $terapis) {
            return $query->where('id_terapis', $terapis);
        });

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });

        return $query->get();
    }
    public function scopeDataBulanIni($query, $terapis, $penyakit)
    {     
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $query->selectRaw('tanggal, COUNT(*) as total')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal');

        $query->when($terapis ?? false, function ($query, $terapis) {
            return $query->where('id_terapis', $terapis);
        });

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });

        return $query->pluck('total', 'tanggal');
    }

    public function scopeDataPerTahun($query, $terapis, $penyakit, $tahun)
    {  
        $query->selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', $tahun)->groupBy('bulan');
        
        $query->when($terapis ?? false, function ($query, $terapis) {
            return $query->where('id_terapis', $terapis);
        });

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });
            
        return $query->get();
    }
    public function scopeDataSemuaTahun($query, $terapis, $penyakit)
    {  
        $query->selectRaw('YEAR(tanggal) as tahun, COUNT(*) as total')
            ->groupBy('tahun')->orderBy('tahun', 'ASC');
        
        $query->when($terapis ?? false, function ($query, $terapis) {
            return $query->where('id_terapis', $terapis);
        });

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->whereHas('subRekamMedis', function ($query) use ($penyakit) {
                $query->where('penyakit', 'like', '%' . $penyakit . '%');
            });
        });
            
        return $query->get();
    }
    
}
