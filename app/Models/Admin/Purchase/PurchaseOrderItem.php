<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Item;

class PurchaseOrderItem extends Model
{
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::Class);
    }
}
