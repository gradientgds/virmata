<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Accounting\Account;

class PurchasePaymentPayable extends Model
{
    public function purchasePayment()
    {
        return $this->belongsTo(PurchasePayment::class);
    }
}
