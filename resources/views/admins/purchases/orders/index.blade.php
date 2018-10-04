@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Hover Data Table</h3>

                <div class="card-tools">
                <a href="{{ route('admin.purchases.orders.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Vendor Name</th>
                            <th>Subtotal</th>
                            <th>Paid</th>
                            <th>Owing</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($purchaseOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->date }}</td>
                            <td>{{ $order->vendor->name }}</td>
                            <td>{{ number_format($order->grand_total, 2) }}</td>
                            <td>{{ number_format($order->payment_total, 2) }}</td>
                            <td>{{ number_format($order->grand_total - $purchaseInvoice->payment_total, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.purchases.orders.show', $order->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                                <a href="{{ route('admin.purchases.orders.show', $order->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                                <a href="{{ route('admin.purchases.orders.show', $order->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
                            </td>
                        </tr>

                            @foreach ($order->bills() as $bill)
                            <tr>
                                <td></td>
                                <td></td>
                                <td><a href="{{ route('admin.purchases.vendors.show', $bill->vendor->id) }}">{{ $bill->vendor->name }}</a></td>
                                <td>{{ number_format($bill->total, 2) }}</td>
                                <td>{{ number_format($bill->payments->sum('pivot.amount'), 2) }}</td>
                                <td>{{ number_format($bill->total - $bill->payments->sum('pivot.amount'), 2) }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>

                    <tfoot>
                        <!-- <tr>
                            <th>Rendering engine</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th>Engine version</th>
                            <th>CSS grade</th>
                        </tr> -->
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
