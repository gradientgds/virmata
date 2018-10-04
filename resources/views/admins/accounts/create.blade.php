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
			<form role="form" method="POST" action="{{ route('admin.accounts.store') }}">
			@csrf
				<div class="card-body">
					<div class="form-group">
						<label>Minimal</label>
						<select class="form-control select2" style="width: 100%;" name="account_type_id">
						@foreach ($accountTypes as $id => $name)
							<option value="{{ $id }}">{{ $name }}</option>
						@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="exampleInputPassword1">Account Number</label>
						<input type="text" class="form-control" id="exampleInputPassword1" name="number" placeholder="Account Number" value="{{ old('number') }}">
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">Account Name</label>
						<input type="text" class="form-control" id="exampleInputEmail1" name="name" placeholder="Account Name"  value="{{ old('name') }}">
					</div>
					<div class="form-group">
						<label>Minimal</label>
						<select class="form-control select2" style="width: 100%;" name="parent_id">
						<option value="0">ROOT ACCOUNT</option>
						@foreach ($parentAccounts as $id => $name)
							<option value="{{ $id }}">{{ $name }}</option>
						@endforeach
						</select>
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
