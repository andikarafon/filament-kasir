<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class Pos extends Component
{

    public $search = '';

    public function render()
    {
        return view('livewire.pos', [
            'products' => Product::where('stock', '>', 0)
                            ->search($this->search)
                            ->paginate(12)
        ]);
    }
}
