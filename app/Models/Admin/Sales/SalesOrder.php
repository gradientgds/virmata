<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Admin\Marketplace;

class SalesOrder extends Model
{
    protected $casts = [
        'ppn' => 'boolean',
        'ppn_included' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class);
    }

    public function marketplace()
    {
        return $this->belongsTo(Marketplace::class);
    }

    public function orderItems()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function orderTotals()
    {
        return $this->hasMany(SalesOrderTotal::class);
    }

    public function orderAccounts()
    {
        return $this->hasMany(SalesOrderAccount::class);
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
