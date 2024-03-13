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
        //
        $orderItem = $event->orderItem;
        $qty = $orderItem->qty;
        $product = $orderItem->product;
        $stockProduct = $product->stock;
        $product->stock = ($stockProduct - $qty);
        $product->save();
        // if()
    }
}
