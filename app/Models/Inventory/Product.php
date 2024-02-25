<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'slug',
        'author_id',
        'price',
        'sale_price',
        'stock',
        'status_stock'
    ];
    public $timestamp = true;

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($product) {
            event(new \App\Events\UpdateProductStock($product));
        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(!$this->{$this->primaryKey}) {
            $this->slug = $this->uniqueSlug($this->name);
        }
    }

    public function details()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }

    public function getPrice()
    {
        if($this->sale_price) {
            return $this->sale_price;
        }

        return $this->price;
    }

    public function getPriceFormated()
    {
        if($this->sale_price) {
            return '<del class="mr-2"> RP. '. number_format($this->price, 2, ',', '.') ."</del> Rp. " . number_format($this->sale_price, 2, ',', '.');
        }

        return "Rp. ".number_format($this->price, 2, ',', '.');
    }

    public function uniqueSlug($slug)
    {
        $slug = \Illuminate\Support\Str::slug($slug);

        $isExists = DB::table('products')->where(['slug' => $slug])->exists();
        if($isExists) {
            $slug .= " copy";
            $slug = \Illuminate\Support\Str::slug($slug);
            return $this->uniqueSlug($slug);
        }

        return $slug;
    }
}
