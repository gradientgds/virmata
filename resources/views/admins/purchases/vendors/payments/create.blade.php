@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
	<div class="col-xs-12">
		<div class="box">
        
			<div class="box-header">
				<h3 class="box-title">Responsive Hover Table</h3>
		 
				<div class="box-tools">

					<div class="input-group input-group-sm" style="width: 150px;">
						<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

						<div class="input-group-btn">
							<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			
			<div class="box-body">

				<form method="POST" action="{{ route('admin.purchases.vendors.payments.store', $vendor->id) }}">
                    @csrf

					<div class="col-xs-3">

						<div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control" name="date" value="{{ old('date', now()->format('Y-m-d')) }}">
                        </div>

						<div class="form-group">
							<label>Account</label>
							<select class="form-control" name="account_id">
                                <option value="">-- Pick One --</option>
                                @foreach ($accounts as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
							</select>
						</div>

					</div>

					@if ($errors->any())
					<div class="col-xs-12">
						<div class="alert alert-error alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							@foreach ($errors->all() as $error)
								<strong>Error!</strong> {{ $error }}.
							@endforeach
						</div>
					</div>
					@endif

					<table class="table table-hover">

                        <tr>
							<th>Type</th>
							<th>ID</th>
							<th>Bill Amount</th>
							<th>Payment Amount</th>
						</tr>

						<?php $stock = 0 ?>
						@foreach ($vendor->bills() as $bill)
						<tr>
							<td>{{ get_class($bill) }}</td>
							<td>{{ $bill->id }}</td>
							<td>{{ number_format((get_class($bill) == App\Models\Admin\Purchase\PurchaseInvoice::class ? $bill->grand_total : $bill->amount), 2) }}</td>
							<td>
								<input type="hidden" name="vendorPaymentRows[payable_type][]" value="{{ get_class($bill) }}">
								<input type="hidden" name="vendorPaymentRows[payable_id][]" value="{{ $bill->id }}">
								<input type="number" class="form-control" name="vendorPaymentRows[amount][]">
							</td>
						</tr>
						@endforeach

                    </table>

					<div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
					
				</form>

			</div>
		<!-- /.box-body -->
		</div>
	<!-- /.box -->
	</div>
</div>
@endsection
