@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Sales Invoice #{{ $invoice->id }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.sales.invoices.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
                    <a href="{{ route('admin.sales.customers.payments.create', $invoice->customer->id) }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-coins fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">

                <p>Date: {{ date_format(date_create($invoice->date), 'd-m-Y') }}</p>
                <p>Due Date: {{ date_format(date_create($invoice->due_date), 'd-m-Y') }}</p>
                @if (isset($invoice->customer->id))
                    <p>Customer: <a href="{{ route('admin.sales.customers.show', $invoice->customer->id) }}">{{ $invoice->customer->name }}</a></p>
                @endif
                <p>Description: {{ $invoice->description }}</p>
                <p>PPN: {{ $invoice->ppn }}</p>
                <p>PPN Included: {{ $invoice->ppn_included }}</p>
                <p>Seller: {{ $invoice->seller->name }}</p>
                <p>Marketplace: {{ $invoice->marketplace->name }}</p>
                <p>Marketplace Invoice: {{ $invoice->marketplace_invoice_number }}</p>
                <p>Accurate Invoice: {{ $invoice->accurate_invoice_number }}</p>

                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice->invoiceItems as $invoiceItem)
                        <tr>
                            <td>{{ $invoiceItem->item->name }}</td>
                            <td>{{ $invoiceItem->quantity }}</td>
                            <td>{{ number_format($invoiceItem->price, 2) }}</td>
                            <td>{{ number_format($invoiceItem->quantity * $invoiceItem->price, 2) }}</td>
                        </tr>
                        @endforeach

                        @if (isset($invoice->customer->id))
                        @foreach ($invoice->invoiceTotals as $invoiceTotal)
                        <tr>
                            <td colspan="3" style="text-align: right">{{ __($invoiceTotal->name) }} :</td>
                            <td>{{ number_format($invoiceTotal->amount, 2) }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

                @if (isset($invoice->customer->id))
                <table class="table table-hover mt-5">

                    <tr>
                        <th>Vendor Name</th>
                        <th>Auto Deduct</th>
                        <th>Account Name</th>
                        <th>Memo</th>
                        <th>Amount</th>
                    </tr>

                    @foreach ($invoice->invoiceAccounts as $invoiceAccount)
                    <tr>
                        <td>{{ $invoiceAccount->vendor->name }}</td>
                        <td>{{ $invoiceAccount->auto_deduct }}</td>
                        <td>{{ $invoiceAccount->account->name }}</td>
                        <td>{{ $invoiceAccount->memo }}</td>
                        <td>{{ number_format($invoiceAccount->amount, 2) }}</td>
                    </tr>
                    @endforeach

                </table>
                @endif
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
