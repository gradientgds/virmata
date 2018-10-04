@extends('layouts.adminlte3.app')

@section ('content')
<div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hover Data Table</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
            <thead>
            <!-- <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Name</th>
            </tr> -->
            </thead>
            <tbody>
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $income])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $cogs])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $expense])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $otherIncome])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $otherExpense])

				<tr style="font-weight: bold; border-top: 2px solid black;">
					<td>Profit/Loss:</td>
					<td colspan="2" style="text-align: right;">{{ number_format($income->total() - $cogs->total() - $expense->total() + $otherIncome->total() - $otherExpense->total(), 2) }}</td>
				</tr>
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