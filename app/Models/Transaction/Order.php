<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'status',
        'paid_at',
        'customer_id',
        'items_subtotal',
        'order_total',
        'author_id'
    ];
    public $timestamps = true;

    public function details()
    {
        return $this->hasOne(OrderDetails::class, 'order_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id', 'id');
    }

    public function getStatusLabel()
    {
        return config("order.status.{$this->status}") ?? $this->status;
    }

    public function getCreatedAtFormated($format = 'L')
    {
        return \Carbon\Carbon::parse($this->created_at)->translatedFormat($format);
    }
}
