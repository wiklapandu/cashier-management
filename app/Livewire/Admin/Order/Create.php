<?php

namespace App\Livewire\Admin\Order;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{
    public $items = [];
    public $items_subtotal = 0;
    public $order_total = 0;
    public $temp_items = [];
    public $billings = [];
    public $setBillingDetails = false;
    public $billing_details = [];
    public $billing_method = '';
    public $billing_note;
    public $order = [];
    public $created_at = '';

    public function save()
    {
        $this->dispatch('order-item-calculate-subtotal');
        $this->dispatch('order-item-calculate-order-total');

        $current_user_id = auth()->user()->id;
        
        $this->order['author_id'] = $current_user_id;
        $this->order['items_subtotal'] = $this->items_subtotal;
        $this->order['order_total'] = $this->order_total;

        DB::beginTransaction();
        try {
            $order = new \App\Models\Transaction\Order($this->order);
            $order->created_at = $this->created_at;
            $order->save();
    
            $items = $this->items;
            $items = \Illuminate\Support\Arr::map($this->items, function ($data) {
                $data['product_detail'] = json_encode($data['product_detail']);
                return new \App\Models\Transaction\OrderItems($data);
            });
            $order->items()->saveMany($items);

            Log::info($this->billing_note);
            $order->details()->save(new \App\Models\Transaction\OrderDetails([
                'customer_detail' => json_encode([
                    'customer_id' => $this->order['customer_id'],
                    'user' => \App\Models\User::find($this->order['customer_id']),
                ]),
                'billing_method' => $this->billing_method,
                'billing_detail' => json_encode($this->billing_details),
                'note'           => $this->billing_note,
            ]));

            Log::info('============ done ===========');
            DB::commit();
            return redirect()->route('order.overviews');
        } catch (\Exception $exception) {
            Log::info('============ error ===========');
            Log::info($exception->getMessage());
            Log::info('============ error ===========');
            DB::rollBack();
        }
    }

    #[On('order-item-calculate-subtotal')]
    public function calculateItemSubtotal()
    {
        $items = $this->items;
        $items = is_array($items) ? array_column($items, 'total') : [];
        $this->items_subtotal = array_sum($items) ?? 0;
    }

    #[On('order-item-calculate-order-total')]
    public function calculateOrderTotal()
    {
        $items = $this->items;
        $items = is_array($items) ? array_column($items, 'total') : [];
        $this->order_total = array_sum($items) ?? 0;
    }

    public function addItem()
    {
        $product_id = $this->temp_items['product_id'];
        $product = \App\Models\Inventory\Product::find($product_id);
        $product_name = $product->name;
        $price = $product->getPrice();
        $quantity = $this->temp_items['qty'];
        $total = $quantity * $price;

        $product_detail = [
            'product_id' => $product_id,
            'price' => $price,
            'price_html' => $product->getPriceFormated(),
        ];

        $this->items[] = [
            'product_id'    => $product_id,
            'product_name'  => $product_name,
            'qty'           => $quantity,
            'product_detail'=> $product_detail,
            'addons'        => null,
            'total'         => $total,
        ];

        $this->dispatch('order-item-calculate-subtotal');
        $this->dispatch('order-item-calculate-order-total');
        $this->unsetTempItem();   
    }

    public function editItem($index)
    {
        $product_id = $this->temp_items['product_id'];
        $product = \App\Models\Inventory\Product::find($product_id);
        $product_name = $product->name;
        $price = $product->getPrice();
        $quantity = $this->temp_items['qty'];
        $total = $quantity * $price;

        $product_detail = [
            'product_id' => $product_id,
            'price' => $price,
            'price_html' => $product->getPriceFormated(),
        ];

        $this->items[$index] = [
            'product_id'    => $product_id,
            'product_name'  => $product_name,
            'qty'           => $quantity,
            'product_detail'=> $product_detail,
            'addons'        => null,
            'total'         => $total,
        ];

        $this->dispatch('order-item-calculate-subtotal');
        $this->dispatch('order-item-calculate-order-total');

        $this->unsetTempItem();   
    }

    public function addRowItem()
    {
        $this->temp_items['product_id'] = '';
        $this->temp_items['qty'] = 1;
    }

    public function confirmRemoveRow($index)
    {
        $this->dispatch('swal:confirm', json_encode([
            'title' => 'Are you sure want to remove this item?',
            'text'  => '<p>after you click Confirm, the row will be remove.</p>',
            'confirmButtonText' => 'Confirm',
            'cancelButtonText' => 'Cancel',
            'event' => 'order-items-remove-row',
            'event_params' => [
                'index' => $index,
            ],
        ]));
    }

    #[On('order-items-remove-row')]
    public function removeRow($index)
    {
        unset($this->items[$index]);
        $this->dispatch('order-item-calculate-subtotal');
        $this->dispatch('order-item-calculate-order-total');
    }

    #[On('temp-item-set-product')]
    public function setProductId($id)
    {
        $this->temp_items['product_id'] = $id;
    }

    public function confirmUnsetTempItem()
    {
        $this->dispatch('swal:confirm', json_encode([
            'title' => 'Are you sure want to unset this?',
            'text'  => '<p>after you click Confirm, the row will be remove.</p>',
            'confirmButtonText' => 'Confirm',
            'cancelButtonText' => 'Cancel',
            'event' => 'unset-temp-item',
        ]));
    }
    
    #[On('unset-temp-item')]
    public function unsetTempItem()
    {
        unset($this->temp_items['product_id']);
        $this->temp_items['qty'] = 1;
    }

    public function render()
    {
        $statusLists = config('order.status');
        $customersLists = \App\Models\User::query()->pluck('name', 'id')->all();
        return view('livewire.admin.order.create', compact('statusLists', 'customersLists'));
    }

    public function toggleBillingDetails()
    {
        $this->setBillingDetails = !$this->setBillingDetails;
    }
}
