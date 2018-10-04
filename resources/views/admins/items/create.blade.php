@extends('layouts.adminlte3.app')

@section('content')
<div class="card">
	<div class="card-header">
		<h3 class="card-title">Quick Example</h3>
	</div>
	<!-- /.card-header -->

	<!-- form start -->
	<form role="form" method="POST" action="{{ route('admin.items.store') }}">
	@csrf
		<div class="card-body">
			<div class="form-group">
				<label for="exampleInputPassword1">Item SKU</label>
				<input type="text" class="form-control" id="exampleInputPassword1" name="sku" placeholder="Item SKU" value="{{ old('sku') }}">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Item Name</label>
				<input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Item Name"  value="{{ old('name') }}">
			</div>
		</div>
		<!-- /.card-body -->

		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
		</div>
	</form>
</div>
<!-- /.card -->
@endsection
