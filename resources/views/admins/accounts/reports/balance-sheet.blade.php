@extends('layouts.adminlte3.app')

@section ('content')
<div class="row">
    <div class="col-6">
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">AKTIVA</h3>
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
				<tr>
					<td colspan="3" style="font-weight: bold; text-transform: uppercase;">AKTIVA LANCAR</td>
				</tr>

				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $cashBank])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $accountReceivable])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $inventory])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $otherCurrentAsset])

				<tr>
					<td colspan="3" style="font-weight: bold; text-transform: uppercase;">AKTIVA TETAP</td>
				</tr>

				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $fixedAsset])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $accumulatedDepresiation])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $otherFixedAsset])

				<tr style="font-weight: bold; border-top: 2px solid black;">
					<td colspan="2">Total Aktiva:</td>
					<td style="text-align: right;">{{ number_format($cashBank->total() + $accountReceivable->total() + $inventory->total() + $otherCurrentAsset->total() + $fixedAsset->total() + $accumulatedDepresiation->total() + $otherFixedAsset->total(), 2) }}</td>
				</tr>
            </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->

	<div class="col-6">
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">PASIVA</h3>
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
				<tr>
					<td colspan="3" style="font-weight: bold; text-transform: uppercase;">HUTANG JANGKA PENDEK</td>
				</tr>

				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $currentDebt])
				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $otherCurrentDebt])

				<tr>
					<td colspan="3" style="font-weight: bold; text-transform: uppercase;">HUTANG JANGKA PANJANG</td>
				</tr>

				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $longTermDebt])

				<tr>
					<td colspan="3" style="font-weight: bold; text-transform: uppercase;">EQUITY / CAPITAL</td>
				</tr>

				@include ('admins/accounts/reports/partials/accounts', ['accountType' => $equity])

				<tr style="font-weight: bold; border-top: 2px solid black;">
					<td colspan="2">Total Pasiva:</td>
					<td style="text-align: right;">{{ number_format($currentDebt->total() + $otherCurrentDebt->total() + $longTermDebt->total() + $equity->total() + $profitLoss, 2) }}</td>
				</tr>
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
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection