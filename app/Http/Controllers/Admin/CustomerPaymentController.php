<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Sales\Customer;

use App\Models\Admin\Sales\SalesInvoice as Invoice;
use App\Models\Admin\Sales\SalesPayment as Payment;
use App\Models\Admin\Sales\SalesPaymentReceivable as PaymentInvoice;

class CustomerPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admins.sales.customers.payments.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $customer = Customer::findOrFail($id);
        $accounts = Account::where('account_type_id', 1)->pluck('name', 'id');

        return view('admins.sales.customers.payments.create', compact('customer', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date, 'Asia/Jakarta');

        $payment = new Payment;
        
        $payment->customer_id = $id;
        $payment->account_id = $request->account_id;
        $payment->date = $date;
        $payment->description = $request->description;

        $payment->save();

        foreach ($request->paymentRows as $key => $entry)
        {
            if (isset($entry['amount']) && $entry['amount'])
            {
                $invoice = Invoice::findOrFail($key);

                $invoice->invoicePayments()->attach($payment->id, ['amount' => $entry['amount']]);
            }  
        }

        return redirect()->route('admins.sales.customers.show', $id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
