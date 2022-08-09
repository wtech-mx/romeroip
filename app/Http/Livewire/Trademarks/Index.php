<?php

namespace App\Http\Livewire\Trademarks;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.trademarks.index')
        ->extends('layouts.app')
        ->section('content');
    }
}
