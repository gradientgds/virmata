@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Sales Invoices</h3>

                <div class="card-tools">
				<a href="{{ route('admin.sales.invoices.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
							<th>ID</th>
							<th>Date</th>
							<th>Customer Name</th>
							<th>Account Receivable</th>
							<th>Total Paid</th>
							<th>Still Owing</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
						@foreach ($invoices as $invoice)
						<tr>
							<td>{{ $invoice->id }}</td>
							<td>{{ date_format(date_create($invoice->date), 'd-m-Y') }}</td>
							<td><a href="{{ route('admin.sales.customers.show', $invoice->customer->id) }}">{{ $invoice->customer->name }}</a></td>
							<td>{{ number_format($invoice->account_receivable) }}</td>
							<td>{{ number_format($invoice->total_payments) }}</td>
							<td>{{ number_format($invoice->account_receivable - $invoice->total_payments) }}</td>
                            <td>
                                <a href="{{ route('admin.sales.invoices.show', $invoice->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.invoices.edit', $invoice->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.invoices.show', $invoice->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.customers.payments.create', $invoice->customer->id) }}"><button class="btn btn-default"><i class="fa fa-coins fa-fw"></i></button></a>
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
