<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\ShippingService;
use App\Models\Admin\Item;
use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\Vendor;
use App\Models\Admin\Sales\Customer;
use App\Models\Admin\Sales\SalesQuotation as Quotation;
use App\Models\Admin\Sales\SalesQuotationItem as QuotationItem;
use App\Models\Admin\Sales\SalesQuotationTotal as QuotationTotal;
use App\Models\Admin\Sales\SalesQuotationAccount as QuotationAccount;

class SalesQuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations = Quotation::all();

        return view('admins.sales.quotations.index', compact('quotations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = DB::table('customers')->select(DB::raw("id, CONCAT(`name`, ' - ', `phone`) as `name_phone`"))->get()->pluck('name_phone', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        $shippingServices = ShippingService::all()->pluck('name', 'id');

        return view('admins.sales.quotations.create', compact('customers', 'vendors', 'items', 'accounts', 'users', 'shippingServices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // // Errors

        // if (count($itemEntries) < 1)
        // {
        //     $errors[] = 'You need to input at least 1 product entry or 1 account entry.';
        // }

        // if (! $customer)
        // {
        //     $errors[] = 'You need to input the customer.';
        // }

        // if(isset($errors))
        // {
        //     return redirect()->route('admins.sales.quotations.create')
        //         ->withErrors($errors)
        //         ->withInput();
        // }

        $quotation = $this->storeQuotation($request);

        $subTotalItems = $this->storeItems($request, $quotation);

        $subTotalAccounts = $this->storeAccounts($request, $quotation);

        $this->storeTotals($request, $quotation, $subTotalItems);

        return redirect()->route('admins.sales.quotations.show', $quotation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        $customers = Customer::all()->pluck('name', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');

        return view('admins.sales.quotations.show', compact('customers', 'vendors', 'items', 'accounts', 'quotation'));
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

    private function storeQuotation(Request $request)
    {
        // Save Quotation

        $quotation = new Quotation;

        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date, 'Asia/Jakarta');
        $customer = Customer::findOrFail($request->customer_id);

        $quotation->customer_id = $customer->id;
        $quotation->date = $date ?? now();
        $quotation->due_date = $date ?? now();
        $quotation->ppn = $request->ppn ?? false;
        $quotation->ppn_included = $request->ppn_included ?? false;
        $quotation->seller_id = $request->seller_id;
        $quotation->shipping_service_id = $request->shipping_service_id;
        $quotation->description = $request->description;

        $quotation->save();

        return $quotation;
    }

    private function storeItems(Request $request, SalesQuotation $quotation)
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

        // Save Quotation Items

        $subTotalItems = 0;

        foreach ($itemEntries as $entry)
        {
            $quotationItem = new QuotationItem;

            $quotationItem->sales_quotation_id = $quotation->id;
            $quotationItem->item_id = $entry['item_id'];
            $quotationItem->quantity = $entry['quantity'];
            $quotationItem->price = $entry['price'];

            $subTotalItems += $entry['quantity'] * $entry['price'];
            
            $quotationItem->save();
        }

        return $subTotalItems;
    }

    private function storeAccounts(Request $request, SalesQuotation $quotation)
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

        // Save Quotation Accounts

        $subTotalAccounts = 0;
        $subTotalFobAccounts = 0;

        foreach ($accountEntries as $entry)
        {
            $quotationAccount = new QuotationAccount;

            $quotationAccount->sales_quotation_id = $quotation->id;
            $quotationAccount->vendor_id = $entry['vendor_id'];
            $quotationAccount->account_id = $entry['account_id'];
            $quotationAccount->fob = $entry['fob'] ?? 0;
            $quotationAccount->amount = $entry['amount'];
            $quotationAccount->memo = $entry['memo'];

            $subTotalAccounts += $entry['amount'];
            
            if ($entry['fob'] == 1)
            {
                $subTotalFobAccounts += $entry['amount'];
            }

            $quotationAccount->save();
        }

        return $subTotalAccounts;
    }

    private function storeTotals(Request $request, SalesQuotation $quotation, $subTotalItems)
    {
        // Save Quotation Totals

        $discount = 0;
        $ppn = 0;
        $shipping_fee_income = 0;
        $grand_total = 0;
        $i = 0;

        foreach ($request->totalRows as $key => $row)
        {
            $amount = 0;
            $quotationTotal = new QuotationTotal;

            $quotationTotal->sales_quotation_id = $quotation->id;
            $quotationTotal->code = $key;
            $quotationTotal->name = (($key == 'tax_ppn' && $request->ppn_included) ? 'sales.invoices.tax_ppn_included' : "sales.invoices.$key");

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

            $quotationTotal->amount = $amount;
            $quotationTotal->order = $i;

            $quotationTotal->save();
            $i++;
        }
    }
}
