<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderProductStockChange
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(\App\Events\OrderProductStock $event): void
    {
        // ? Decrease Stock of Product
        $orderItem = $event->orderItem;
        $order = $orderItem->order;
        $qty = $orderItem->qty;
        if($order->status === 'pending-payment') return;
        
        $product = $orderItem->product;
        $stockProduct = $product->stock;

        if(in_array($order->status, ['cancelled'])) {
            $product->stock = ($stockProduct + $qty);
        } else {
            $product->stock = ($stockProduct - $qty);
        }

        $product->save();
    }
}
