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

				<form method="POST" action="{{ route('admin.vendors.update', $vendor->id) }}">
                    @csrf
                    <input name="_method" type="hidden" value="PATCH">

					<div class="col-xs-3">

						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" id="name" name="name" value="{{ old('name', $vendor->name) }}">
						</div>

						<div class="form-group">
							<label for="phone">Phone</label>
							<input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}">
						</div>

						<p><button type="submit" class="btn btn-primary">Submit</button></p>
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
					
				</form>

			</div>
		<!-- /.box-body -->
		</div>
	<!-- /.box -->
	</div>
</div>
@endsection
