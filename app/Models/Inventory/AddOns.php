<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOns extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'addons_products';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    public function productAddOns()
    {
        return $this->belongsTo(ProductAddOns::class, 'addons_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(AddOnsItems::class, 'parent_id', 'id');
    }
}
