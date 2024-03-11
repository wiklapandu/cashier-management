<?php

namespace App\Livewire\Admin\Order;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{
    public $items = [];
    public $temp_items = [];
    public $billings = [];
    public $setBillingDetails = false;
    public $billing_details = [];
    public $order = [];

    public function save()
    {
        $current_user_id = auth()->user()->id;
    }

    public function addItem()
    {
        
    }

    public function addRowItem()
    {
        $this->temp_items['product_id'] = '';
        $this->temp_items['qty'] = 1;
    }

    #[On('temp-item-set-product')]
    public function setProductId($id)
    {
        $this->temp_items['product_id'] = $id;
    }

    public function unsetTempItem()
    {
        unset($this->temp_items['product_id']);
        $this->temp_items['qty'] = 1;
    }

    public function render()
    {
        $statusLists = (new \App\Models\Transaction\Order)->getStatusLists();
        $customersLists = \App\Models\User::query()->pluck('name', 'id')->all();
        return view('livewire.admin.order.create', compact('statusLists', 'customersLists'));
    }

    public function toggleBillingDetails()
    {
        $this->setBillingDetails = !$this->setBillingDetails;
    }
}
