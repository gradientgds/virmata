<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Item;
use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\PurchaseOrder as Order;
use App\Models\Admin\Purchase\PurchaseOrderItem as OrderItem;
use App\Models\Admin\Purchase\PurchaseOrderTotal as OrderTotal;
use App\Models\Admin\Purchase\PurchaseOrderAccount as OrderAccount;
use App\Models\Admin\Purchase\Vendor;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseOrders = Order::all();

        return view('admins.purchases.orders.index', compact('purchaseOrders'));
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

        return view('admins.purchases.orders.create', compact('vendors', 'items', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Item Rows

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

        $vendor = Vendor::find($request->vendor_id);

        // Errors

        if (count($itemEntries) < 1)
        {
            $errors[] = 'You need to input at least 1 product entry.';
        }

        if (! $vendor)
        {
            $errors[] = 'You need to input the vendor.';
        }

        if(isset($errors))
        {
            return redirect()->route('admins.purchase.orders.create')
                ->withErrors($errors)
                ->withInput();
        }

        // Save Order

        $order = new Order;

        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date, 'Asia/Jakarta');
        $due_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->due_date, 'Asia/Jakarta');

        $order->date = $date ?? now();
        $order->due_date = $due_date ?? now()->addWeek()->format('Y-m-d');
        $order->description = $request->description;
        $order->ppn = $request->ppn ?? false;
        $order->ppn_included = $request->ppn_included ?? false;

        $vendor->purchaseOrders()->save($order);

        // Save Items

        $subTotalItems = 0;

        foreach ($itemEntries as $entry)
        {
            $orderItem = new OrderItem;

            $orderItem->purchase_order_id = $order->id;
            $orderItem->item_id = $entry['item_id'];
            $orderItem->quantity = $entry['quantity'];
            $orderItem->price = $entry['price'];
            
            $subTotalItems += $entry['quantity'] * $entry['price'];

            $orderItem->save();
        }

        // Save Accounts

        $subTotalAccounts = 0;

        foreach ($AccountEntries as $entry)
        {
            $orderAccount = new OrderAccount;

            $orderAccount->purchase_order_id = $invoice->id;
            $orderAccount->vendor_id = $entry['vendor_id'];
            $orderAccount->account_id = $entry['account_id'];
            $orderAccount->amount = $entry['amount'];
            $orderAccount->memo = $entry['memo'];

            $subTotalAccounts += $orderAccount->amount;

            $orderAccount->save();
        }

        // Save Totals

        $discount = 0;
        $ppn = 0;
        $i = 0;

        foreach ($request->totalRows as $key => $row)
        {
            $amount = 0;

            $orderTotal = new OrderTotal;

            $orderTotal->purchase_order_id = $order->id;
            $orderTotal->code = $key;
            $orderTotal->name = (($key == 'tax_ppn' && $order->ppn_included) ? 'purchases.orders.tax_ppn_included' : "purchases.orders.$key");

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
                if ($order->ppn)
                {
                    if ($order->ppn_included)
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
            // else if ($key == 'item_total')
            // {
            //     if ($invoice->ppn)
            //     {
            //         if ($invoice->ppn_included)
            //         {
            //             $amount = $subTotalItems - $discount;
            //         }
            //         else
            //         {
            //             $amount = $subTotalItems - $discount + $ppn;
            //         }
            //     }
            //     else
            //     {
            //         $amount = $subTotalItems - $discount;
            //     }
            // }
            else if ($key == 'account_total')
            {
                $amount = $subTotalAccounts;
            }
            else if ($key == 'grand_total')
            {
                if ($order->ppn)
                {
                    if ($order->ppn_included)
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

                // $amount += $subTotalAccounts;
            }

            $orderTotal->amount = $amount;
            $orderTotal->order = $i;

            $orderTotal->save();
            $i++;
        }

        return redirect()->route('admins.purchases.orders.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = PurchaseOrder::findOrFail($id);

        return view('admins.purchases.orders.show', compact('order'));
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
