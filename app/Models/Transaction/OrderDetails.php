<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'order_id',
        'customer_detail',
        'billing_method',
        'billing_detail',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }
}
