@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Hover Data Table</h3>

                <div class="card-tools">
				<a href="{{ route('admins.sales.customers.payments.create', $customer->id) }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Account Name</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($customer->salesPayments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->account->name }}</td>
                            <td>{{ number_format($payment->total_payments, 2) }}</td>
                            <td></td>
                        </tr>
                        @endforeach
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
