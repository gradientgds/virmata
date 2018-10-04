<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Item;

class SalesInvoiceItem extends Model
{
    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::Class);
    }

    public function itemable()
    {
        return $this->morphOne(ItemLog::class, 'itemable');
    }

    public function related()
    {
        return $this->morphMany(ItemLog::class, 'related');
    }

    public function getQuantityProcessedAttribute()
    {
        return $this->morphMany(ItemLog::class, 'related')->sum('quantity');
    }

    public function getQuantityProcessingAttribute()
    {
        return $this->quantity - $this->quantity_processed;
    }
}
