<?php

namespace App\Listeners;

use App\Events\UpdateProductStock;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStockStatusListener
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
    public function handle(UpdateProductStock $event): void
    {
        //
        $product = $event->product;

        if($product->stock === 0)
        {
            $product->status_stock = 'outstock';
            $product->save();
        } elseif ($product->stock > 0 && $product->status_stock === 'outstock') {
            $product->status_stock = 'instock';
            $product->save();
        }
    }
}
