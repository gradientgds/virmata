<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Models\Admin\Marketplace;

class SalesInvoice extends Model
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

    public function invoiceItems()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }

    public function invoiceTotals()
    {
        return $this->hasMany(SalesInvoiceTotal::class);
    }

    public function invoiceAccounts()
    {
        return $this->hasMany(SalesInvoiceAccount::class);
    }

    public function invoicePayments()
    {
        return $this->belongsToMany(SalesPayment::class, 'sales_payment_receivables')->withPivot('amount');
    }

    public function getSubTotalAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'sub_total')->first()->amount;
    }

    public function getDiscountAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'discount')->first()->amount;
    }

    public function getTaxPpnAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'tax_ppn')->first()->amount;
    }

    public function getItemTotalAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'item_total')->first()->amount;
    }

    public function getShippingFeeIncomeAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'shipping_fee_income')->first()->amount;
    }

    public function getTotalAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'item_total')->first()->amount;
    }

    public function getAccountTotalAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'account_total')->first()->amount;
    }

    public function getGrandTotalAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'grand_total')->first()->amount;
    }

    public function getAccountReceivableAttribute($value)
    {
        return $this->invoiceTotals()->where('code', 'account_receivable')->first()->amount;
    }

    public function getTotalPaymentsAttribute($value)
    {
        return $this->invoicePayments->sum('pivot.amount');
    }
}
