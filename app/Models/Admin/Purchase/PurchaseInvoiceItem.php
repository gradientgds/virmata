<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Item;

class PurchaseInvoiceItem extends Model
{
    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::Class);
    }
}
