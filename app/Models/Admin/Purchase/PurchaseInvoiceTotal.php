<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceTotal extends Model
{
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
