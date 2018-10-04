<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Accounting\Account;

class PurchaseInvoiceAccount extends Model
{
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function payments()
    {
        return $this->morphToMany(PurchasePayment::class, 'payable', 'purchase_payment_payables')->withPivot('amount');
    }

    public function getTotalAttribute($value)
    {
        return $this->amount;
    }
}
