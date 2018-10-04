<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Accounting\Account;

class SalesPayment extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function salesInvoices()
    {
        return $this->belongsToMany(SalesInvoice::class, 'sales_payment_receivables')->withPivot('amount');
    }
}
