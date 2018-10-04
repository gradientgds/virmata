@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Customer - Sales Invoices</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.sales.customers.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
                    <a href="{{ route('admin.sales.customers.payments.create', $customer->id) }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-coins fa-fw"></i></button></a>
				</div>
            </div>

            <!-- /.card-header -->
            <div class="card-body">

                <p>Customer Name: {{ $customer->name }}</p>
                <p>Customer Phone: {{ $customer->phone }}</p>
                <p>Customer Address (RAW): {{ $customer->address_raw }}</p>
                
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Account Receivable</th>
                        <th>Total Paid</th>
                        <th>Owing</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->salesInvoices as $invoice)
                        <tr>
							<td>{{ $invoice->id }}</td>
							<td>{{ date_format(date_create($invoice->date), 'd-m-Y') }}</td>
							@if (isset($invoice->customer->id))
							    <td>{{ $invoice->customer->name }}</td>
							@else
							    <td>N/A</td>
							@endif
							<td>{{ number_format($invoice->account_receivable, 2) }}</td>
							<td>{{ number_format($invoice->total_payments, 2) }}</td>
							<td>{{ number_format($invoice->account_receivable - $invoice->total_payments, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.sales.invoices.show', $invoice->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.invoices.edit', $invoice->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.invoices.show', $invoice->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
                            </td>
                            
						</tr>
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
