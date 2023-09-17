<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Jadwal;
use Livewire\Component;
use Livewire\WithPagination;

class JadwalDashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $tanggal, $tglAwal, $tglAkhir, $periode;
    public $filter = "Today", $tglCaption, $prevTanggal, $prevTglAwal, $prevTglAkhir, $prevPeriode;

    protected $listeners = ['setFilterTanggal', 'setFilterRange'];

    public function mount()
    {
        if (session()->has('livewire_page')) {
            $this->page = session('livewire_page');
        }
    }
    
    public function render()
    {
        $query = Jadwal::query();

        if($this->tanggal == '' && $this->tglAwal == '' && $this->tglAkhir == '' && $this->periode == '') {
            $this->resetPage();
        }

        if ($this->tanggal !== $this->prevTanggal || $this->tglAwal !== $this->prevTglAwal || $this->tglAkhir !== $this->prevTglAkhir || $this->periode !== $this->prevPeriode) {
            $this->resetPage();
        }
    
        $this->prevTanggal = $this->tanggal;
        $this->prevTglAwal = $this->tglAwal;
        $this->prevTglAkhir = $this->tglAkhir;
        $this->prevPeriode = $this->periode;
        
        if($this->filter === "Periode") {
            $m = $this->periode == "tahun-ini" ? date('Y') : date('Y-m');
            $query->where('tanggal', 'like', $m . '%');
            $this->tglCaption = $this->periode == "tahun-ini" ? date('Y') : Carbon::today()->formatLocalized('%B %Y');
        } elseif($this->filter === "Tunggal") {
            $this->tglCaption = Carbon::parse($this->tanggal)->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', $this->tanggal);

        } elseif($this->filter === "Range")  {
            $awal = Carbon::parse($this->tglAwal)->formatLocalized('%d %B %Y');
            $akhir = Carbon::parse($this->tglAkhir)->formatLocalized('%d %B %Y');

            $this->tglCaption = $awal . ' - ' . $akhir;
            $query->whereBetween('tanggal', [$this->tglAwal, $this->tglAkhir]);
        } else {            
            $this->tglCaption = Carbon::today()->formatLocalized('%A, %d %B %Y');
            $query->where('tanggal', Carbon::today()->format('Y-m-d'));
        }

        $jadwal_terapi = $query->orderBy('tanggal')->orderBy('waktu')->paginate(10);


        return view('livewire.jadwal-dashboard', compact(
            'jadwal_terapi', 
        ));
    }

    public function setFilterPeriode($value) {
        $this->filter = "Periode";
        $this->periode = $value;
    }
    public function setFilterTanggal($value) {
        $this->filter = "Tunggal";
        $this->tanggal = $value;        
        $this->tglAwal = "";
        $this->tglAkhir = "";
    }

    public function setFilterRange($value) {
        $this->filter = "Range";
        $this->tglAwal = $value['awal'];
        $this->tglAkhir = $value['akhir'];
        $this->tanggal = "";  
    }

    
    public function ambilJadwal($id_jadwal, $id_terapis)
    {        
        Jadwal::where('id_jadwal', $id_jadwal)->update(['id_terapis' => $id_terapis]);
    }
    public function lepasJadwal($id_jadwal)
    {        
        Jadwal::where('id_jadwal', $id_jadwal)->update(['id_terapis' => null]);
    }
}
