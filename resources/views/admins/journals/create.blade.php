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
			<form role="form" method="POST" action="{{ route('admin.journals.store') }}">
			@csrf
				<div class="card-body">

					<div class="form-group">
						<label for="date">Date</label>
						<input type="date" class="form-control" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}">
					</div>
					
					<div class="form-group">
						<label>Description</label>
						<textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
					</div>

					<table id="example1" class="table table-bordered">
						<thead>
							<tr>
								<th>Account Name</th>
								<th>Debit</th>
								<th>Credit</th>
								<th>Memo</th>
							</tr>
						</thead>

						<tbody>
							@for ($i=0; $i < 10; $i++)
							<tr>
								<td>
								<select class="form-control select2" name="journalEntries[account_id][]">
									<option value="">-- Pick One --</option>
									@foreach ($accounts as $id => $name)
									<option value="{{ $id }}">{{ $name }}</option>
									@endforeach
								</select>
								</td>
								<td><input type="number" class="form-control" name="journalEntries[debit][]"></td>
								<td><input type="number" class="form-control" name="journalEntries[credit][]"></td>
								<td><input type="text" class="form-control" name="journalEntries[memo][]"></td>
							</tr>
							@endfor
						</tbody>

						<tfoot>
							<!-- <tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
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
