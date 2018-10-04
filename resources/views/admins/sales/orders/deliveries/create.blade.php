@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Create a Delivery for Sales Order #{{ $order->id }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.sales.orders.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
                    <a href="{{ route('admin.sales.orders.deliveries.create', $order->id) }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-truck fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form role="form" method="POST" action="{{ route('admin.sales.orders.deliveries.store', $order->id) }}">
			@csrf

            <div class="card-body">

                <div class="form-group">
                    <p>Name : {{ $order->customer->name }}</p>
                </div>

                <div class="form-group">
                    <p>Phone : {{ $order->customer->phone }}</p>
                </div>

                <div class="form-group">
                    <p>Address (RAW) : {!! nl2br($order->customer->address_raw) !!}</p>
                </div>

                <div class="form-group">
                    <label for="date">Date</label>
                    <datepicker-input name="date" value="{{ old('date', \Carbon\Carbon::createFromFormat('Y-m-d', $order->date)->format('d-m-Y') ) }}"></datepicker-input>
                    <!-- <datepicker-input name="date" value="{{ old('date', now()->format('d-m-Y')) }}"></datepicker-input> -->
                    <!-- <input type="text" class="form-control" id="datepicker" name="date" value="{{ old('date', now()->format('d-m-Y')) }}"> -->
                </div>

                <div class="form-group">
                    <label>Shipping Service</label>
                    <select class="form-control select2" name="shipping_service_id">
                        <option></option>
                        @foreach ($shippingServices as $id => $name)
                            @if ($order->shipping_service_id == $id)
                            <option value="{{ $id }}" selected="selected">{{ $name }}</option>
                            @else
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <table id="example1" class="table table-bordered table-hover mt-5">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Order Quantity</th>
                            <th>Deliver All</th>
                            <th>Deliver Quantity</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($order->orderItems as $itemEntry)
                        @if ($itemEntry->quantity_processing)
                            
                        <tr>
                            <td>
                                {{ $itemEntry->item->name }}
                                <input type="hidden" name="itemRows[{{ $itemEntry->id }}][item_id]]" value="{{ $itemEntry->item->id }}">
                            </td>
                            <td>Delivered: {{ $itemEntry->quantity_processed }} |  Not Delivered: {{ $itemEntry->quantity_processing }} / {{ $itemEntry->quantity }}</td>
                            <td>
                                <input type="checkbox" name="itemRows[{{ $itemEntry->id }}][deliver_all]" checked="checked">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="itemRows[{{ $itemEntry->id }}][quantity]" min="0" max="{{ $itemEntry->quantity_processing }}">
                                <input type="hidden" name="itemRows[{{ $itemEntry->id }}][from_id]]" value="{{ $itemEntry->id }}">
                                <input type="hidden" name="itemRows[{{ $itemEntry->id }}][from_type]]" value="Admin\Sales\SalesOrderItem">
                            </td>
                        </tr>
                        
                        @endif
                        @endforeach
                    </tbody>
                </table>

                <account-table></account-table>
                
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- /.card-footer -->

            </form>
            <!-- form end -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
