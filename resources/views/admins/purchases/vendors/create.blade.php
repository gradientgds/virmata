@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Quick Example</h3>
			</div>
			<!-- /.card-header -->

			<!-- form start -->
			<form role="form" method="POST" action="{{ route('admin.purchases.vendors.store') }}">
			@csrf
				<div class="card-body">
					<div class="form-group">
						<label for="exampleInputEmail1">Vendor Name</label>
						<input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Vendor Name"  value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Vendor Phone</label>
						<input type="text" class="form-control" id="exampleInputPassword1" name="phone" placeholder="Vendor Phone" value="{{ old('phone') }}">
					</div>
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
