<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Item;

class SalesQuotationItem extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::Class);
    }

    public function orderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }
}
