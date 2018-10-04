@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Customer Payment</h3>
			</div>
			<!-- /.card-header -->

			<!-- form start -->
			<form role="form" method="POST" action="{{ route('admins.sales.customers.payments.store', $customer->id) }}">
			@csrf
				<div class="card-body">
					<div class="form-group">
						<label for="exampleInputEmail1">Date</label>
						<input type="text" class="form-control" id="datepicker" name="date" value="{{ old('date', now()->format('d-m-Y')) }}">
					</div>

					<div class="form-group">
						<label>Account</label>
						<select class="form-control select2" name="account_id">
							<option></option>
							@foreach ($accounts as $id => $name)
								<option value="{{ $id }}">{{ $name }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

					<table id="example1" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Date</th>
								<th>Account Receivable</th>
								<th>Total Paid</th>
								<th>Balance</th>
								<th>Full Paid</th>
								<th>Payment</th>
							</tr>
						</thead>

						<tbody>
							@foreach ($customer->salesInvoices as $invoice)
							<tr>
								<td>{{ $invoice->id }}</td>
								<td>{{ date_format(date_create($invoice->date), 'd-m-Y') }}</td>
								<td>{{ number_format($invoice->account_receivable, 2) }}</td>
								<td>{{ number_format($invoice->total_payments, 2) }}</td>
								<td>{{ number_format($invoice->account_receivable - $invoice->total_payments, 2) }}</td>
								<td><input type="checkbox" name="paymentRows[{{ $invoice->id }}][full_paid]"></td>
								<td><input type="number" class="form-control" name="paymentRows[{{ $invoice->id }}][amount]"></td>
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

				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
		<!-- /.card -->
	</div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
