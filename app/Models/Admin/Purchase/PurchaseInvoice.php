<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Accounting\AccountPayable;

class PurchaseInvoice extends Model
{
    protected $casts = [
        'ppn' => 'boolean',
        'ppn_included' => 'boolean',
    ];

    public function invoiceItems()
    {
        return $this->hasMany(PurchaseInvoiceItem::class);
    }

    public function invoiceTotals()
    {
        return $this->hasMany(PurchaseInvoiceTotal::class);
    }

    public function invoiceAccounts()
    {
        return $this->hasMany(PurchaseInvoiceAccount::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function accounts()
    {
        return $this->morphToMany(Account::class, 'journalable', 'journal_entries');
    }

    public function bills()
    {
        return PurchaseInvoice::where('id', $this->id)->get()->concat(PurchaseInvoiceAccount::where('purchase_invoice_id', $this->id)->get());
    }

    public function payments()
    {
        return $this->morphToMany(PurchasePayment::class, 'payable', 'purchase_payment_payables')->withPivot('amount');
    }

    public function subTotal()
    {
        return $this->invoiceItems->sum(function($invoiceItem){
            return $invoiceItem->quantity * $invoiceItem->price;
        });
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

    public function getPaymentTotalAttribute($value)
    {
        $total = 0;

        foreach ($this->bills() as $bill)
        {
            $total += $bill->payments->sum('pivot.amount');
        }

        return $total;
    }

    
}
