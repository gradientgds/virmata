@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Sales Order #{{ $order->id }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.sales.orders.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
                    <a href="{{ route('admin.sales.orders.deliveries.create', $order->id) }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-truck fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">

                <p>Date: {{ date_format(date_create($order->date), 'd-m-Y') }}</p>
                <p>Due Date: {{ date_format(date_create($order->due_date), 'd-m-Y') }}</p>
                @if (isset($order->customer->id))
                    <p>Customer: <a href="{{ route('admin.sales.customers.show', $order->customer->id) }}">{{ $order->customer->name }}</a></p>
                @endif
                <p>Description: {{ $order->description }}</p>
                <p>PPN: {{ $order->ppn }}</p>
                <p>PPN Included: {{ $order->ppn_included }}</p>
                <p>Seller: {{ $order->seller->name }}</p>
                <p>Marketplace: {{ $order->marketplace->name ?? 'N/A' }}</p>
                <p>Marketplace Invoice: {{ $order->marketplace_invoice_number }}</p>

                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Ordered Quantity</th>
                            <th>Delivered Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->orderItems as $itemEntry)
                        <tr>
                            <td>{{ $itemEntry->item->name }}</td>
                            <td>{{ $itemEntry->quantity }}</td>
                            <td>{{ $itemEntry->quantity_processed }}</td>
                            <td>{{ number_format($itemEntry->price, 2) }}</td>
                            <td>{{ number_format($itemEntry->quantity * $itemEntry->price, 2) }}</td>
                        </tr>
                        @endforeach

                        @if (isset($order->customer->id))
                        @foreach ($order->orderTotals as $totalEntry)
                        <tr>
                            <td colspan="4" style="text-align: right">{{ __($totalEntry->name) }} :</td>
                            <td>{{ number_format($totalEntry->amount, 2) }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

                @if (isset($order->customer->id))
                <table class="table table-bordered table-hover mt-5">

                <tr>
                    <th>Vendor Name</th>
                    <th>Account Name</th>
                    <th>Amount</th>
                    <th>Memo</th>
                </tr>

                @foreach ($order->orderAccounts as $accountEntry)
                <tr>
                    <td>{{ $accountEntry->vendor->name }}</td>
                    <td>{{ $accountEntry->account->name }}</td>
                    <td>{{ number_format($accountEntry->amount, 2) }}</td>
                    <td>{{ $accountEntry->memo }}</td>
                </tr>
                @endforeach

                </table>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
