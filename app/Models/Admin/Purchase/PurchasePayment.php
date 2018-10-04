<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Accounting\Account;

class PurchasePayment extends Model
{
    public function purchasePaymentPayables()
    {
        return $this->hasMany(PurchasePaymentPayable::class);
    }

    public function purchaseInvoices()
    {
        return $this->morphedByMany(PurchaseInvoice::class, 'payable', 'account_payables');
    }

    public function purchaseInvoiceAccounts()
    {
        return $this->morphedByMany(PurchaseInvoiceAccount::class, 'payable', 'account_payables');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
