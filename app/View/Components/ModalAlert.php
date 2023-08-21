<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalAlert extends Component
{
    public $id, $title, $body, $icon;

    public function __construct($id, $title, $body, $icon )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.modal-alert');
    }
}
