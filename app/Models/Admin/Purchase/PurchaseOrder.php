<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $casts = [
        'ppn' => 'boolean',
        'ppn_included' => 'boolean',
    ];
    
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function orderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function orderTotals()
    {
        return $this->hasMany(PurchaseOrderTotal::class);
    }

    public function getSubTotalAttribute($value)
    {
        return $this->orderTotals()->where('code', 'sub_total')->first()->amount;
    }

    public function getDiscountAttribute($value)
    {
        return $this->orderTotals()->where('code', 'discount')->first()->amount;
    }

    public function getTaxPpnAttribute($value)
    {
        return $this->orderTotals()->where('code', 'tax_ppn')->first()->amount;
    }

    public function getGrandTotalAttribute($value)
    {
        return $this->orderTotals()->where('code', 'grand_total')->first()->amount;
    }
}
