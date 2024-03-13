<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddOns extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'product_has_addons';
    protected $primaryKey = 'id';
    protected $fillable = ['product_id', 'addons_id', 'price'];
    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'product_id');
    }
    public function addons()
    {
        return $this->hasMany(AddOns::class, 'id', 'addons_id');
    }
}
