<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnsItems extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'addons_items';
    protected $primaryKey = 'id';
    protected $fillable  = ['parent_id', 'sku', 'stock', 'price'];
    public function parent()
    {
        return $this->belongsTo(AddOns::class, 'parent_id', 'id');
    }
}
