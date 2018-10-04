<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Purchase\PurchaseInvoiceItem;
use App\Models\Admin\Sales\SalesInvoiceItem;

class Item extends Model
{
    public function itemable()
    {
        return $this->morphTo();
    }

    public function purchaseInvoiceItems()
    {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }

    public function salesInvoiceItems()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }

    public function historyItems()
    {
        return PurchaseInvoiceItem::where('item_id', $this->id)->with('purchaseInvoice')->get()->concat(SalesInvoiceItem::where('item_id', $this->id)->with('salesInvoice')->get())->sortBy('date');
    }
}
