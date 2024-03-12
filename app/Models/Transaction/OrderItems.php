<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'order_items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_detail',
        'addons',
        'qty',
        'total',
    ];
    public $timestamps = false;
    
    public function product()
    {
        return $this->hasOne(\App\Models\Inventory\Product::class, 'id', 'product_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
