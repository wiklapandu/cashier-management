<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function details()
    {
        return $this->hasOne(ProductDetail::class, 'product_id', 'id');
    }
}
