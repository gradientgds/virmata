<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\ItemLog;
use App\Models\ShippingService;
use App\Models\Admin\Accounting\Account;
use App\Models\Admin\Purchase\Vendor;
use App\Models\Admin\Sales\SalesOrder;
use App\Models\Admin\Sales\SalesOrderItem;
use App\Models\Admin\Sales\SalesOrderAccount;
use App\Models\Admin\Sales\SalesDelivery;
use App\Models\Admin\Sales\SalesDeliveryItem;

class SalesOrderDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $order = SalesOrder::findOrFail($id);
        // $deliveries = ItemLog::with('targetable')->whereIn('sourceable_id', $order->orderItems->pluck('id'))->get();
        $deliveries = Itemlog::where('targetable_type', 'App\Models\Admin\Sales\SalesDeliveryItem')
                            ->where('sourceable_type', 'App\Models\Admin\Sales\SalesOrderItem')
                            ->whereIn('sourceable_id', $order->orderItems->pluck('id'))
                            ->with('targetable')
                            ->get()
                            ->unique('targetable.sales_delivery_id');
        return view('admins/sales/orders/deliveries/index', compact('order', 'deliveries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $order = SalesOrder::findOrFail($id);
        $shippingServices = ShippingService::all()->pluck('name', 'id');
        $vendors = Vendor::all()->pluck('name', 'id');
        $accounts = Account::all()->pluck('name', 'id');
        return view('admins.sales.orders.deliveries.create', compact('order', 'shippingServices', 'vendors', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $itemRows = array();

        foreach ($request->itemRows as $row)
        {
            if (isset($row['item_id']) && (isset($row['deliver_all']) || !empty($row['quantity'])) )
            {
                $itemRows[] = $row;
            }
        }

        $accountRows = array();
        
        foreach ($request->accountRows as $row)
        {
            if (isset($row['account_id']) && isset($row['account_id']) && isset($row['amount']))
            {
                $accountRows[] = $row;
            }
        }

        $order = SalesOrder::findOrFail($id);
        $delivery = new SalesDelivery;

        $delivery->customer_id = $order->customer->id;
        $delivery->shipping_service_id = $request->shipping_service_id;
        $delivery->date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date, 'Asia/Jakarta');

        $delivery->save();

        foreach ($itemRows as $row)
        {
            $deliveryItem = new SalesDeliveryItem;

            $deliveryItem->sales_delivery_id = $delivery->id;
            $deliveryItem->item_id = $row['item_id'];
            $deliveryItem->quantity = isset($row['deliver_all']) ? SalesOrderItem::find($row['from_id'])->quantity : $row['quantity'];

            $deliveryItem->save();

            $itemLog = $deliveryItem->targetable()->create([]);

            if ( !empty($row['from_id']) )
            {
                $class = 'App\Models\\'.$row['from_type'];
                $relation = app($class)->find($row['from_id']);
                $itemLog->sourceable()->associate($relation)->save();
            }
        }

        // Save Order Accounts

        $subTotalAccounts = 0;

        foreach ($accountRows as $row)
        {
            $orderAccount = new SalesOrderAccount;

            $orderAccount->sales_order_id = $order->id;
            $orderAccount->vendor_id = $row['vendor_id'];
            $orderAccount->account_id = $row['account_id'];
            $orderAccount->amount = $row['amount'];
            $orderAccount->memo = $row['memo'];

            $subTotalAccounts += $row['amount'];
            
            $orderAccount->save();
        }

        return redirect()->route('admin.sales.orders.deliveries.index', $order->id);
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
