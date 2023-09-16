<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Jadwal;
use Livewire\Component;
use Livewire\WithPagination;

class JadwalLanding extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $jadwal_terapi = Jadwal::where('tanggal', date('Y-m-d'))->orderBy('waktu')->paginate(5);
        $today = Carbon::today()->formatLocalized('%A, %d %B %Y');
        
        return view('livewire.jadwal-landing', compact('jadwal_terapi', 'today'));
    }
}
