<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Item;
use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\PurchaseInvoice as Invoice;
use App\Models\Admin\Purchase\PurchaseInvoiceItem as InvoiceItem;
use App\Models\Admin\Purchase\PurchaseInvoiceTotal as InvoiceTotal;
use App\Models\Admin\Purchase\PurchaseInvoiceAccount as InvoiceAccount;
use App\Models\Admin\Purchase\Vendor;



class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseInvoices = Invoice::all();

        return view('admins.purchases.invoices.index', compact('purchaseInvoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');

        return view('admins.purchases.invoices.create', compact('vendors', 'items', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Item Entries

        $invoiceItems = array();

        foreach ($request->invoiceItemRows as $key => $row)
        {
            foreach ($row as $index => $value)
            {
                $invoiceItemRows[$index][$key] = $value;
            }
        }

        foreach ($invoiceItemRows as $row)
        {
            if (isset($row['item_id']) && isset($row['quantity']) && isset($row['price']))
            {
                $invoiceItems[] = $row;
            }
        }

        // Account Entries

        $invoiceAccounts = array();

        foreach ($request->invoiceAccountRows as $key => $row)
        {
            foreach ($row as $index => $value)
            {
                $invoiceAccountRows[$index][$key] = $value;
            }
        }

        foreach ($invoiceAccountRows as $row)
        {
            if (isset($row['account_id']) && isset($row['amount']))
            {
                $invoiceAccounts[] = $row;
            }
        }

        $vendor = Vendor::find($request->vendor_id);

        // Errors

        if (count($invoiceItems) < 1)
        {
            $errors[] = 'You need to input at least 1 product entry.';
        }

        if (! $vendor)
        {
            $errors[] = 'You need to input the vendor.';
        }

        if(isset($errors))
        {
            return redirect()->route('admins.purchase.invoice.create')
                ->withErrors($errors)
                ->withInput();
        }

        // Save Invoice

        $invoice = new Invoice;

        $invoice->date = $request->date ?? now();
        $invoice->due_date = $request->due_date ?? now()->addWeek()->format('Y-m-d');
        $invoice->ppn = $request->ppn ?? false;
        $invoice->ppn_included = $request->ppn_included ?? false;

        $vendor->purchaseInvoices()->save($invoice);

        // Save Items

        $subTotalItems = 0;

        foreach ($invoiceItems as $entry)
        {
            $invoiceItem = new InvoiceItem;

            $invoiceItem->purchase_invoice_id = $invoice->id;
            $invoiceItem->item_id = $entry['item_id'];
            $invoiceItem->quantity = $entry['quantity'];
            $invoiceItem->price = $entry['price'];

            $subTotalItems += $entry['quantity'] * $entry['price'];
            $invoiceItem->save();
        }

        // Save Accounts

        $subTotalAccounts = 0;

        foreach ($invoiceAccounts as $entry)
        {
            if ($entry['account_id'] == PPN_MASUKAN)
            {
                // $account = Account::find($entry['account_id']);
                // $invoice->accounts()->attach($account, ['amount' => $entry['amount'], 'debit_credit' => 'debit', 'memo' => '']);

                // $account = Account::find(1);
                // $invoice->accounts()->attach($account, ['amount' => $entry['amount'], 'debit_credit' => 'credit', 'memo' => '']);

                
            }
            else
            {
                $invoiceAccount = new PurchaseInvoiceAccount;

                $invoiceAccount->purchase_invoice_id = $invoice->id;
                $invoiceAccount->vendor_id = $entry['vendor_id'];
                $invoiceAccount->account_id = $entry['account_id'];
                $invoiceAccount->amount = $entry['amount'];
                $invoiceAccount->memo = $entry['memo'];

                $subTotalAccounts += $invoiceAccount->amount;

                $invoiceAccount->save();
            }
        }

        // Save Totals

        $discount = 0;
        $ppn = 0;
        $i = 0;

        foreach ($request->invoiceTotalRows as $key => $row)
        {
            $amount = 0;
            $invoiceTotal = new PurchaseInvoiceTotal;

            $invoiceTotal->purchase_invoice_id = $invoice->id;
            $invoiceTotal->code = $key;
            $invoiceTotal->name = (($key == 'tax_ppn' && $invoice->ppn_included) ? 'purchases.invoices.tax_ppn_included' : "purchases.invoices.$key");

            if ($key == 'sub_total')
            {
                $amount = $subTotalItems;
            }
            else if ($key == 'discount')
            {
                $discount = $row ?? 0;
                $amount = $discount;
            }
            else if ($key == 'tax_ppn')
            {
                if ($invoice->ppn)
                {
                    if ($invoice->ppn_included)
                    {
                        $ppn = ($subTotalItems - $discount) / 11;
                    }
                    else
                    {
                        $ppn = ($subTotalItems - $discount) / 10; 
                    }
                }
                else
                {
                    $ppn = 0;
                }

                $amount = $ppn;
            }
            else if ($key == 'item_total')
            {
                if ($invoice->ppn)
                {
                    if ($invoice->ppn_included)
                    {
                        $amount = $subTotalItems - $discount;
                    }
                    else
                    {
                        $amount = $subTotalItems - $discount + $ppn;
                    }
                }
                else
                {
                    $amount = $subTotalItems - $discount;
                }
            }
            else if ($key == 'account_total')
            {
                $amount = $subTotalAccounts;
            }
            else if ($key == 'grand_total')
            {
                if ($invoice->ppn)
                {
                    if ($invoice->ppn_included)
                    {
                        $amount = $subTotalItems - $discount;
                    }
                    else
                    {
                        $amount = $subTotalItems - $discount + $ppn;
                    }
                }
                else
                {
                    $amount = $subTotalItems - $discount;
                }

                $amount += $subTotalAccounts;
            }

            $invoiceTotal->amount = $amount;
            $invoiceTotal->order = $i;

            $invoiceTotal->save();
            $i++;
        }

        // PERSEDIAAN BARANG - ACCOUNT ID #3
        // $account = Account::find(3);
        // $invoice->accounts()->attach($account, ['amount' => $invoice->sub_total - $invoice->discount + $invoice->account_total, 'debit_credit' => 'debit', 'memo' => '']);

        // // ACCOUNT PAYABLE - ACCOUNT ID #1
        // $account = Account::find(1);
        // $invoice->accounts()->attach($account, ['amount' => $invoice->sub_total - $invoice->discount + $invoice->account_total, 'debit_credit' => 'credit', 'memo' => '']);

        // JournalEntries::salesInvoice($invoice);
        // JournalEntries::purchaseInvoice($invoice);
        // JournalEntries::salesPayment($payment);

        return redirect()->route('admins.purchases.invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = PurchaseInvoice::findOrFail($id);

        return view('admins.purchases.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = PurchaseInvoice::findOrFail($id);

        return view('admins.purchases.invoices.edit', compact('invoice'));
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
