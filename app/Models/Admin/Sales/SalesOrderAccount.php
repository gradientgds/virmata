<?php

namespace App\Models\Admin\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\Vendor;

class SalesOrderAccount extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
