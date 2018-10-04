@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Add New Customer</h3>
			</div>
			<!-- /.card-header -->

			<!-- form start -->
			<form role="form" method="POST" action="{{ route('admin.sales.customers.store') }}">
			@csrf
				<div class="card-body">
					<div class="form-group">
						<label for="exampleInputEmail1">Customer Name</label>
						<input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Customer Name"  value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Customer Phone</label>
						<input type="text" class="form-control" id="exampleInputPassword1" name="phone" placeholder="Customer Phone" value="{{ old('phone') }}">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Customer Address</label>
						<textarea rows="15" class="form-control" name="address_raw"></textarea>
					</div>
				</div>
				<!-- /.card-body -->

				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
				<!-- /.card-footer -->
			</form>
		</div>
		<!-- /.card -->
	</div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
