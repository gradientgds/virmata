@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Deliveries for Sales Order #{{ $order->id }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.sales.orders.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
                    <a href="{{ route('admin.sales.orders.deliveries.create', $order->id) }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-truck fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form role="form" action="{{ route('admin.sales.invoices.create') }}">
			@csrf

            <div class="card-body">

                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($deliveries as $delivery)
                        <tr>
                            <td colspan="3">{{ $delivery->targetable->salesDelivery->id }} / {{ $delivery->targetable->salesDelivery->date }}</td>
                        </tr>

                            @foreach ($delivery->targetable->salesDelivery->deliveryItems as $entry)
                            <tr>
                                <td></td>
                                <td>{{ $entry->item->name }}</td>
                                <td>{{ $entry->quantity }}</td>
                            </tr>

                            @endforeach
                        
                        @endforeach 
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        </form>
        <!-- form end -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
