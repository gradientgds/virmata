<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\User;

class SalesQuotation extends Model
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

    public function quotationItems()
    {
        return $this->hasMany(SalesQuotationItem::class);
    }

    public function quotationTotals()
    {
        return $this->hasMany(SalesQuotationTotal::class);
    }

    public function quotationAccounts()
    {
        return $this->hasMany(SalesQuotationAccount::class);
    }
}
