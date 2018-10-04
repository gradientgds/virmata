@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Hover Data Table</h3>

                <div class="card-tools">
                    
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Vendor Name</th>
                            <th>Account Name</th>
                            <th>Payment Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($purchasePayments as $payment)
                        <tr>
                            <td><a href="{{ route('admin.purchases.vendors.show', $payment->vendor->id) }}">{{ $payment->vendor->id }}</a></td>
                            <td>{{ $payment->date }}</td>
                            <td>{{ $payment->vendor->name }}</td>
                            <td>{{ $payment->account->name }}</td>
                            <td>{{ number_format($payment->purchasePaymentPayables->sum('amount'), 2) }}</td>
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
