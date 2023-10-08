<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Pasien;
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
    public function terapis()
    {
        return $this->belongsTo(Terapis::class, 'id_terapis');
    }
    public function subRekamMedis()
    {
        return $this->hasMany(SubRekamMedis::class, 'id_rekam_medis');
    }

    public function scopeDataMingguIni($query, $penyakit)
    {     
        $year = Carbon::now()->year;
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $query->selectRaw('tanggal_selesai as tanggal, COUNT(*) as total')
            ->where('status_pasien', 'Selesai')
            ->whereYear('tanggal_selesai', $year)
            ->whereBetween('tanggal_selesai', [$startOfWeek, $endOfWeek])
            ->groupBy('tanggal_selesai');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->where('penyakit', 'like', '%' . $penyakit . '%');
        });
            
        return $query->get();
    }
    public function scopeDataBulanIni($query, $penyakit)
    {     
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $query->selectRaw('tanggal_selesai as tanggal, COUNT(*) as total')
            ->where('status_pasien', 'Selesai')
            ->whereBetween('tanggal_selesai', [$startDate, $endDate])
            ->groupBy('tanggal_selesai')
            ->orderBy('tanggal_selesai');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->where('penyakit', 'like', '%' . $penyakit . '%');
        });
            
        return $query->pluck('total', 'tanggal');
    }

    public function scopeDataPerTahun($query, $penyakit, $tahun)
    {  
        $query->selectRaw('MONTH(tanggal_selesai) as bulan, COUNT(*) as total')
            ->where('status_pasien', 'Selesai')
            ->whereYear('tanggal_selesai', $tahun)->groupBy('bulan');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->where('penyakit', 'like', '%' . $penyakit . '%');
        });
            
        return $query->get();
    }    
    
    public function scopeDataSemuaTahun($query, $penyakit)
    {  
        $query->selectRaw('YEAR(tanggal_selesai) as tahun, COUNT(*) as total')
            ->where('status_pasien', 'Selesai')
            ->groupBy('tahun')->orderBy('tahun', 'ASC');

        $query->when($penyakit ?? false, function ($query, $penyakit) {
            return $query->where('penyakit', 'like', '%' . $penyakit . '%');
        });
            
        return $query->get();
    }    
}
