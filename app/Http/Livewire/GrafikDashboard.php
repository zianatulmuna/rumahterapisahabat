<?php

namespace App\Http\Livewire;

use App\Models\Terapis;
use Livewire\Component;
use App\Models\SubRekamMedis;

class GrafikDashboard extends Component
{
    public $menu = 'sesi-terapi', $filter = 'tahun-ini', $terapis, $penyakit;
    public function render()
    {
        $terapis = Terapis::orderBy('nama', 'ASC')->get();
        $penyakit = SubRekamMedis::distinct('penyakit')->orderBy('penyakit', 'ASC')->pluck('penyakit');
        return view('livewire.grafik-dashboard', compact(
            'terapis',
            'penyakit',
            'dataGrafik',
        ));
    }
}
