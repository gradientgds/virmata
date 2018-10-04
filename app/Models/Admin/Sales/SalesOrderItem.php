<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Item;
use App\Models\Admin\ItemLog;

class SalesOrderItem extends Model
{
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::Class);
    }

    public function item()
    {
        return $this->belongsTo(Item::Class);
    }

    public function sourceable()
    {
        return $this->morphMany(ItemLog::class, 'sourceable');
    }

    public function targetable()
    {
        return $this->morphOne(ItemLog::class, 'targetable');
    }
    
    public function getQuantityProcessedAttribute()
    {
        return $this->sourceable()->with('targetable')->get()->sum('targetable.quantity');
    }

    public function getQuantityProcessingAttribute()
    {
        return $this->quantity - $this->quantity_processed;
    }
}
