<?php

namespace App\Models\Admin\Purchase;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class);
    }

    public function purchaseInvoiceAccounts()
    {
        return $this->hasMany(PurchaseInvoiceAccount::class);
    }

    public function purchasePayments()
    {
        return $this->hasMany(PurchasePayment::class);
    }

    public function bills()
    {
        return PurchaseInvoice::where('vendor_id', $this->id)->get()->concat(PurchaseInvoiceAccount::where('vendor_id', $this->id)->get());
    }

    public function xxx()
    {
        $total = 0;

        foreach ($this->bills() as $bill)
        {
            $total += $bill->payments->sum('amount');
        }

        return $total;
    }

    public function balance()
    {
        $total = 0;
        
        foreach ($this->purchaseInvoices as $invoice)
        {
            $total += $invoice->grand_total;
        }

        foreach ($this->purchaseInvoiceAccounts as $invoiceAccount)
        {
            $total += $invoiceAccount->amount;
        }

        foreach ($this->purchasePayments as $payment)
        {
            $total -= $payment->purchasePaymentPayables->sum('amount');
        }

        return $total;
    }
}
