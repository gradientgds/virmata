@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Hover Data Table</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.purchases.invoices.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">

                <p>Date: {{ $invoice->date }}</p>
                <p>Due Date: {{ $invoice->due_date }}</p>
                <p>Vendor: {{ $invoice->vendor->name }}</p>
                <p>PPN: {{ $invoice->ppn }}</p>
                <p>PPN Included: {{ $invoice->ppn_included }}</p>

                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price HPP</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice->invoiceItems as $invoiceItem)
                        <tr>
                            <td>{{ $invoiceItem->item->name }}</td>
                            <td>{{ $invoiceItem->quantity }}</td>
                            <td>{{ number_format(($invoice->grand_total + $invoice->account_total) / $invoice->sub_total * $invoiceItem->price, 2) }}</td>
                            <td>{{ number_format($invoiceItem->price, 2) }}</td>
                            <td>{{ number_format($invoiceItem->quantity * $invoiceItem->price, 2) }}</td>
                        </tr>
                        @endforeach

                        @foreach ($invoice->invoiceTotals as $invoiceTotal)
                        <tr>
                            <td colspan="4" style="text-align: right">{{ __($invoiceTotal->name) }} :</td>
                            <td>{{ number_format($invoiceTotal->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-bordered table-hover mt-5">
                    <thead>
                        <tr>
                            <th>Vendor Name</th>
                            <th>Account Name</th>
                            <th>Memo</th>
                            <th>Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice->invoiceAccounts as $invoiceAccount)
                        <tr>
                            <td>{{ $invoiceAccount->vendor->name }}</td>
                            <td>{{ $invoiceAccount->account->name }}</td>
                            <td>{{ $invoiceAccount->memo }}</td>
                            <td>{{ number_format($invoiceAccount->amount, 2) }}</td>
                        </tr>
                        @endforeach
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
