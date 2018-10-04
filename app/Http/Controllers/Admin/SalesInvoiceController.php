<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\ShippingService;
use App\Models\Admin\Item;
use App\Models\Admin\Marketplace;
use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\Vendor;
use App\Models\Admin\Sales\Customer;
use App\Models\Admin\Sales\SalesInvoice as Invoice;
use App\Models\Admin\Sales\SalesInvoiceItem as InvoiceItem;
use App\Models\Admin\Sales\SalesInvoiceTotal as InvoiceTotal;
use App\Models\Admin\Sales\SalesInvoiceAccount as InvoiceAccount;

class SalesInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();

        return view('admins.sales.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $customers = Customer::all()->pluck('name', 'id');
        $customers = DB::table('customers')->select(DB::raw("id, CONCAT(`name`, ' - ', `phone`) as `name_phone`"))->get()->pluck('name_phone', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');
        $marketplaces = Marketplace::all()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        $shippingServices = ShippingService::all()->pluck('name', 'id');

        return view('admins.sales.invoices.create', compact('customers', 'vendors', 'items', 'accounts', 'marketplaces', 'users', 'shippingServices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Errors

        // if (count($invoiceItems) < 1)
        // {
        //     $errors[] = 'You need to input at least 1 product entry or 1 account entry.';
        // }

        // if (! $customer)
        // {
        //     $errors[] = 'You need to input the customer.';
        // }

        // if(isset($errors))
        // {
        //     return redirect()->route('admins.sales.invoices.create')
        //         ->withErrors($errors)
        //         ->withInput();
        // }

        $invoice = $this->storeInvoice($request);

        $subTotalItems = $this->storeItems($request, $invoice);

        $subTotalAccounts = $this->storeItems($request, $invoice);
        
        $this->storeTotals($request, $invoice, $subTotalItems);

        return redirect()->route('admins.sales.invoices.show', $invoice->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        return view('admins.sales.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::all()->pluck('name', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');

        return view('admins.sales.invoices.show', compact('customers', 'vendors', 'items', 'accounts', 'invoice'));
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

    private function storeInvoice(Request $request)
    {
        // Save Invoice

        $invoice = new Invoice;

        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date, 'Asia/Jakarta');
        $customer = Customer::findOrFail($request->customer_id);

        $invoice->customer_id = $customer->id;
        $invoice->date = $date ?? now();
        $invoice->due_date = $date ?? now();
        $invoice->ppn = $request->ppn ?? false;
        $invoice->ppn_included = $request->ppn_included ?? false;
        $invoice->seller_id = $request->seller_id;
        $invoice->shipping_service_id = $request->shipping_service_id;
        $invoice->marketplace_id = $request->marketplace_id;
        $invoice->marketplace_invoice_number = $request->marketplace_invoice_number ?? 0;
        $invoice->accurate_invoice_number = $request->accurate_invoice_number ?? 0;
        $invoice->description = $request->description;

        $invoice->save();

        return $invoice;
    }

    private function storeItems(Request $request, SalesInvoice $invoice)
    {
        // Item Entries

        $itemEntries = array();

        foreach ($request->itemRows as $key => $row)
        {
            foreach ($row as $index => $value)
            {
                $itemRows[$index][$key] = $value;
            }
        }

        foreach ($itemRows as $row)
        {
            if (isset($row['item_id']) && isset($row['quantity']) && isset($row['price']))
            {
                $itemEntries[] = $row;
            }
        }

        // Save Invoice Items

        $subTotalItems = 0;

        foreach ($itemEntries as $entry)
        {
            $invoiceItem = new InvoiceItem;

            $invoiceItem->sales_invoice_id = $invoice->id;
            $invoiceItem->item_id = $entry['item_id'];
            $invoiceItem->quantity = $entry['quantity'];
            $invoiceItem->price = $entry['price'];

            $subTotalItems += $entry['quantity'] * $entry['price'];

            $invoiceItem->save();
        }

        return $subTotalItems;
    }

    private function storeAccounts(Request $request, SalesInvoice $invoice)
    {
        // Account Entries

        $accountEntries = array();

        foreach ($request->accountRows as $key => $row)
        {
            foreach ($row as $index => $value)
            {
                $accountRows[$index][$key] = $value;
            }
        }

        foreach ($accountRows as $row)
        {
            if (isset($row['account_id']) && isset($row['amount']))
            {
                $accountEntries[] = $row;
            }
        }

        // Invoice Accounts

        $subTotalAccounts = 0;
        $subTotalFobAccounts = 0;

        foreach ($accountEntries as $entry)
        {
            $invoiceAccount = new InvoiceAccount;

            $invoiceAccount->sales_invoice_id = $invoice->id;
            $invoiceAccount->vendor_id = $entry['vendor_id'];
            $invoiceAccount->account_id = $entry['account_id'];
            $invoiceAccount->amount = $entry['amount'];
            $invoiceAccount->memo = $entry['memo'];
            $invoiceAccount->fob = $entry['fob'] ?? false;

            $subTotalAccounts += $entry['amount'];
            
            if ($invoiceAccount->auto_deduct == 1)
            {
                $subTotalFobAccounts += $entry['amount'];
            }

            $invoiceAccount->save();
        }

        return $subTotalAccounts;
    }

    private function storeTotals(Request $request, SalesInvoice $invoice, $subTotalItems)
    {
        // Invoice Totals

        $discount = 0;
        $ppn = 0;
        $shipping_fee_income = 0;
        $grand_total = 0;
        $i = 0;

        foreach ($request->totalRows as $key => $row)
        {
            $amount = 0;
            $invoiceTotal = new InvoiceTotal;

            $invoiceTotal->sales_invoice_id = $invoice->id;
            $invoiceTotal->code = $key;
            $invoiceTotal->name = (($key == 'tax_ppn' && $request->ppn_included) ? 'sales.invoices.tax_ppn_included' : "sales.invoices.$key");

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
                $ppn = 0;

                if ($request->ppn)
                {
                    if ($request->ppn_included)
                    {
                        $ppn = ($subTotalItems - $discount) / 11;
                    }
                    else
                    {
                        $ppn = ($subTotalItems - $discount) / 10; 
                    }
                }

                $amount = $ppn;
            }
            else if ($key == 'shipping_fee_income')
            {
                $shipping_fee_income = $row ?? 0;
                $amount = $shipping_fee_income;
            }
            else if ($key == 'grand_total')
            {
                $grand_total = $subTotalItems - $discount + $shipping_fee_income;

                if ($request->ppn)
                {
                    if ($request->ppn_included)
                    {
                        $grand_total = $subTotalItems - $discount + $shipping_fee_income;
                    }
                }

                $amount = $grand_total;
            }

            $invoiceTotal->amount = $amount;
            $invoiceTotal->order = $i;

            $invoiceTotal->save();
            $i++;
        }
    }
}
