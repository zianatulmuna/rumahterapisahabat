<?php

namespace App\View\Components;

use Illuminate\View\Component;

class GrafikDashboard extends Component
{
    public $terapis = [], $penyakit = [], $dataGrafik = [], $maxChart;

    public function __construct($terapis, $penyakit, $dataGrafik, $maxChart)
    {
        $this->terapis = $terapis;
        $this->penyakit = $penyakit;
        $this->dataGrafik = $dataGrafik;
        $this->maxChart = $maxChart;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.grafik-dashboard');
    }
}
