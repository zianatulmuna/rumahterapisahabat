<?php

namespace App\Http\Livewire;

use App\Models\Terapis;
use Livewire\Component;

class TerapisReady extends Component
{
    protected $listeners = ['toggleSwitch'];
    public function render()
    {
        $terapis = Terapis::orderBy('nama', 'ASC')->get();
        $terapisReady = $terapis->where('is_ready', 1)->count();
        $terapisForReady = Terapis::orderBy('is_ready', 'DESC')->orderBy('nama', 'ASC')->get();

        return view('livewire.terapis-ready', compact(
            'terapis', 
            'terapisReady', 
            'terapisForReady', 
        ));
    }

    public function toggleSwitch($terapis,$status)
    {
        if($status == 0) {
            Terapis::where('id_terapis', $terapis)->update([
                'is_ready' => 1,
            ]);
        } else {
            Terapis::where('id_terapis', $terapis)->update([
                'is_ready' => 0,
            ]);
        }
    }
    public function offTerapis()
    {
        Terapis::query()->update(['is_ready' => 0]);
    }
}
