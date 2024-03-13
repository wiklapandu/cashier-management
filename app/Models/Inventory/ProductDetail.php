<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'details_product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'product_id',
        'sku',
        'description',
        'short_description',
        'thumbnail',
    ];
    public $timestamps = false;
    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
}
