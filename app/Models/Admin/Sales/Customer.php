<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoice::class);
    }

    public function salesPayments()
    {
        return $this->hasMany(SalesPayment::class);
    }
}
