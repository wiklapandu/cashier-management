<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        \Illuminate\Support\Str::macro('get_price_html', function($price) {
            return "Rp. ".number_format($price, 2, ',', '.');
        });
        
        \Illuminate\Support\Str::macro('get_price_on_sale_html', function($price, $sale_price = 0) {
            if(boolval($sale_price) && $price > $sale_price) {
                return '<del class="mr-2"> RP. '. number_format($price, 2, ',', '.') ."</del> Rp. " . number_format($sale_price, 2, ',', '.');
            }
    
            return "Rp. ".number_format($price, 2, ',', '.');
        });
    }
}
