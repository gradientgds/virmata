@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">

	<form action="get">
	<datepicker-input name="kodok" value="{{ old('date', now()->format('d-m-Y')) }}"></datepicker-input>

	<button type="submit">Submit</button>
	</form>
		
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
