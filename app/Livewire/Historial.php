<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venta;

class Historial extends Component
{
    use WithPagination;

    public function render()
    {
        $ventas = Venta::orderBy('created_at', 'desc')->paginate(10);
        return view('livewire.historial', compact('ventas'));
    }
}
