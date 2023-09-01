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
    
    public $tanggal, $tglAwal, $tglAkhir;
    public $filter = "Today", $tglCaption, $prevTanggal, $prevTglAwal, $prevTglAkhir ;

    protected $listeners = ['setFilterTanggal', 'setFilterRange'];

    public function updatingTanggal()
    {
        // $this->tglCaption = Carbon::today()->formatLocalized('%A, %d %B %Y');
    }
    
    public function render()
    {
        $query = Jadwal::query();

        if ($this->tanggal !== $this->prevTanggal || $this->tglAwal !== $this->prevTglAwal || $this->tglAkhir !== $this->prevTglAkhir) {
            $this->resetPage();
        }
    
        $this->prevTanggal = $this->tanggal;
        $this->prevTglAwal = $this->tglAwal;
        $this->prevTglAkhir = $this->tglAkhir;
        
        if($this->filter === "Tunggal") {
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

        $jadwal_terapi = $query->paginate(10);


        return view('livewire.jadwal-dashboard', compact(
            'jadwal_terapi', 
        ));
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
}
