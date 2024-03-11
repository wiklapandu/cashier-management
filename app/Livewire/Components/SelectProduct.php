<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class SelectProduct extends Component
{
    public $search;
    public $selected = [];

    public $products = [];
    public $listenerName;

    public function render()
    {
        return view('livewire.components.select-product');
    }

    public function mount($value = null, $listenerName = '')
    {
        if($listenerName) {
            $this->listenerName = $listenerName;
        }

        if ($value) {
            try {
                $find = \App\Models\Inventory\Product::query()->find($value, ['name', 'id']);
                $this->selected['label'] = $find->name;
                $this->selected['value'] = $find->id;
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        
        $products = \App\Models\Inventory\Product::query();
        $this->products = $products->take(3)->pluck('name', 'id')->all();
    }

    public function find()
    {
        $value = $this->search;
        // $this->search = $value;
        $products = \App\Models\Inventory\Product::query();
        $products->where('name', 'LIKE', "%$value%");

        $this->products = $products->take(3)->pluck('name', 'id')->all();
    }

    public function choice($label, $value)
    {
        $this->selected = compact('label', 'value');
        $this->search = $label;

        // Emit Listener
        if($this->listenerName) $this->dispatch($this->listenerName, $value);
    }

    public function unset()
    {
        $this->selected = [];
        $this->search = '';
    }
}
