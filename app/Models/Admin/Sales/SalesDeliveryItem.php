<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Item;
use App\Models\Admin\ItemLog;

class SalesDeliveryItem extends Model
{
    public function salesDelivery()
    {
        return $this->belongsTo(SalesDelivery::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function sourceable()
    {
        return $this->morphMany(ItemLog::class, 'sourceable');
    }

    public function targetable()
    {
        return $this->morphOne(ItemLog::class, 'targetable');
    }
}
