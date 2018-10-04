<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesDelivery extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function deliveryItems()
    {
        return $this->hasMany(SalesDeliveryItem::class);
    }
}
