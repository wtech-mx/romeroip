<?php

namespace App\Http\Livewire\Trademarks;

use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        return view('livewire.trademarks.create')
        ->extends('layouts.app')
        ->section('content');
    }
}
