@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Sales Quotations</h3>

                <div class="card-tools">
				<a href="{{ route('admin.sales.quotations.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
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
							<th>Grand Total</th>
							<th>Total Paid</th>
							<th>Still Owing</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
						@foreach ($quotations as $entry)
						<tr>
							<td>{{ $entry->id }}</td>
							<td>{{ date_format(date_create($entry->date), 'd-m-Y') }}</td>
							<td><a href="{{ route('admin.sales.customers.show', $entry->customer->id) }}">{{ $entry->customer->name }}</a></td>
							<td>{{ number_format($entry->grand_total, 2) }}</td>
							<td>{{ number_format($entry->total_payments, 2) }}</td>
							<td>{{ number_format($entry->account_receivable - $entry->total_payments, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.sales.quotations.show', $entry->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.quotations.edit', $entry->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                                <a href="{{ route('admin.sales.quotations.show', $entry->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
                            </td>
                            
						</tr>
						@endforeach
                    </tbody>
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
