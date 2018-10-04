<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\PurchaseInvoice;
use App\Models\Admin\Purchase\PurchaseInvoiceAccount;
use App\Models\Admin\Purchase\PurchasePayment;
use App\Models\Admin\Purchase\PurchasePaymentPayable;
use App\Models\Admin\Purchase\Vendor;

class VendorPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $vendor = Vendor::find($id);
        return view('admins.purchases.vendors.payments.index', compact('vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $vendor = Vendor::find($id);
        $accounts = Account::all()->pluck('name', 'id');

        return view('admins.purchases.vendors.payments.create', compact('vendor', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // Vendor Payments

        $vendorPayments = array();

        foreach ($request->vendorPaymentRows as $key => $row)
        {
            foreach ($row as $index => $value)
            {
                $vendorPaymentRows[$index][$key] = $value;
            }
        }

        foreach ($vendorPaymentRows as $row)
        {
            if (isset($row['payable_type']) && isset($row['payable_id']) && isset($row['amount']))
            {
                $vendorPayments[] = $row;
            }
        }

        $payment = new PurchasePayment;

        $payment->vendor_id = $id;
        $payment->account_id = $request->account_id;
        $payment->date = $request->date;

        $payment->save();

        foreach ($vendorPayments as $entry)
        {
            $paymentPayable = new PurchasePaymentPayable;

            $paymentPayable->payable_type = $entry['payable_type'];
            $paymentPayable->payable_id = $entry['payable_id'];
            $paymentPayable->amount = $entry['amount'];

            $payment->purchasePaymentPayables()->save($paymentPayable);
        }

        return redirect()->route('admins.purchases.vendors.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
