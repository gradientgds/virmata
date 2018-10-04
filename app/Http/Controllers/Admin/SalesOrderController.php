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
use App\Models\Admin\Sales\SalesQuotation;
use App\Models\Admin\Sales\SalesOrder;
use App\Models\Admin\Sales\SalesOrderItem;
use App\Models\Admin\Sales\SalesOrderTotal;
use App\Models\Admin\Sales\SalesOrderAccount;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = SalesOrder::all();

        return view('admins/sales/orders/index', compact('orders'));
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
        $marketplaces = Marketplace::all()->pluck('name', 'id');
        $users = User::all()->pluck('name', 'id');
        $shippingServices = ShippingService::all()->pluck('name', 'id');

        return view('admins/sales/orders/create', compact('customers', 'vendors', 'items', 'accounts', 'marketplaces', 'users', 'shippingServices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());

        // Errors

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
        //     return redirect()->route('admins.sales.orders.create')
        //         ->withErrors($errors)
        //         ->withInput();
        // }

        $order = $this->storeOrder($request);
        $subTotalItems = $this->storeItems($request, $order);
        // $subTotalAccounts = $this->storeAccounts($request, $order);
        $this->storeTotals($request, $order, $subTotalItems);

        return redirect()->route('admin.sales.orders.show', $order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = SalesOrder::findOrFail($id);
        $customers = Customer::all()->pluck('name', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');

        return view('admins/sales/orders/show', compact('customers', 'vendors', 'items', 'accounts', 'order'));
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

    private function storeOrder(Request $request)
    {
        // Save Order

        $order = new SalesOrder;

        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date, 'Asia/Jakarta');
        $customer = Customer::findOrFail($request->customer_id);

        $order->customer_id = $customer->id;
        $order->customer_name = $customer->name;
        $order->customer_phone = $customer->phone;
        $order->customer_address_raw = $customer->address_raw;
        $order->date = $date ?? now();
        $order->due_date = $date ?? now();
        $order->ppn = $request->ppn ? 1 : 0;
        $order->ppn_included = $request->ppn_included ? 1 : 0;
        $order->seller_id = $request->seller_id;
        $order->shipping_service_id = $request->shipping_service_id;
        $order->marketplace_id = $request->marketplace_id;
        $order->reference_number = $request->reference_number ?? 0;
        $order->description = $request->description;

        $order->save();

        return $order;
    }

    private function storeItems(Request $request, SalesOrder $order)
    {
        // Item Entries

        $itemRows = array();

        foreach ($request->itemRows as $row)
        {
            if (!empty($row['item_id']) && !empty($row['quantity']))
            {
                $itemRows[] = $row;
            }
        }

        // Save Order Items

        $subTotalItems = 0;

        foreach ($itemRows as $row)
        {
            $orderItem = new SalesOrderItem;

            $orderItem->sales_order_id = $order->id;
            $orderItem->item_id = $row['item_id'];
            $orderItem->quantity = $row['quantity'];
            $orderItem->price = $row['price'];

            $subTotalItems += $row['quantity'] * $row['price'];
            
            $orderItem->save();

            $itemLog = $orderItem->targetable()->create([]);
        }

        return $subTotalItems;
    }

    private function storeAccounts(Request $request, SalesOrder $order)
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

        // Save Order Accounts

        $subTotalAccounts = 0;
        $subTotalFobAccounts = 0;

        foreach ($accountEntries as $entry)
        {
            $orderAccount = new SalesOrderAccount;

            $orderAccount->sales_order_id = $order->id;
            $orderAccount->vendor_id = $entry['vendor_id'];
            $orderAccount->account_id = $entry['account_id'];
            $orderAccount->amount = $entry['amount'];
            $orderAccount->memo = $entry['memo'];

            $subTotalAccounts += $entry['amount'];
            
            if ($entry['fob'] == 1)
            {
                $subTotalFobAccounts += $entry['amount'];
            }

            $orderAccount->save();
        }

        return $subTotalAccounts;
    }

    private function storeTotals(Request $request, SalesOrder $order, $subTotalItems)
    {
        // Save Order Totals

        $discount = 0;
        $ppn = 0;
        $freight_income = 0;
        $grand_total = 0;
        $i = 0;

        foreach ($request->totalRows as $key => $row)
        {
            $amount = 0;
            $orderTotal = new SalesOrderTotal;

            $orderTotal->sales_order_id = $order->id;
            $orderTotal->code = $key;
            $orderTotal->name = (($key == 'tax_ppn' && $request->ppn_included) ? 'sales.invoices.tax_ppn_included' : "sales.invoices.$key");

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
            else if ($key == 'freight_income')
            {
                $freight_income = $row ?? 0;
                $amount = $freight_income;
            }
            else if ($key == 'grand_total')
            {
                $grand_total = $subTotalItems - $discount + $ppn + $freight_income;

                if ($request->ppn)
                {
                    if ($request->ppn_included)
                    {
                        $grand_total = $subTotalItems - $discount + $freight_income;
                    }
                }

                $amount = $grand_total;
            }

            $orderTotal->amount = $amount;
            $orderTotal->order = $i;

            $orderTotal->save();
            $i++;
        }
    }

    public function createFromQuotation($id)
    {
        $quotation = SalesQuotation::findOrFail($id);
        $customers = DB::table('customers')->select(DB::raw("id, CONCAT(`name`, ' - ', `phone`) as `name_phone`"))->get()->pluck('name_phone', 'id');
        $users = User::all()->pluck('name', 'id');
        $shippingServices = ShippingService::all()->pluck('name', 'id');
        $marketplaces = Marketplace::all()->pluck('name', 'id');
        $items = Item::all()->pluck('name', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');

        return view('admins.sales.quotations.test', compact('customers', 'users', 'shippingServices', 'marketplaces', 'items', 'vendors', 'accounts', 'quotation'));
    }
}
