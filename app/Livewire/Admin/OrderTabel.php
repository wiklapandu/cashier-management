<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class OrderTabel extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = \App\Models\Transaction\Order::query()->paginate(6);
        return view('livewire.admin.order-tabel', compact('orders'));
    }
}
