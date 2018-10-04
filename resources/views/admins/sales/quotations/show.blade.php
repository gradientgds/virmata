@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Sales Quotation #{{ $quotation->id }}</h3>

                <div class="card-tools">
                    <a href="{{ route('admin.sales.quotations.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">

                <p>Date: {{ date_format(date_create($quotation->date), 'd-m-Y') }}</p>
                <p>Due Date: {{ date_format(date_create($quotation->due_date), 'd-m-Y') }}</p>
                @if (isset($quotation->customer->id))
                    <p>Customer: <a href="{{ route('admin.sales.customers.show', $quotation->customer->id) }}">{{ $quotation->customer->name }}</a></p>
                @endif
                <p>Description: {{ $quotation->description }}</p>
                <p>PPN: {{ $quotation->ppn }}</p>
                <p>PPN Included: {{ $quotation->ppn_included }}</p>
                <p>Seller: {{ $quotation->seller->name }}</p>

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
                        @foreach ($quotation->quotationItems as $itemEntry)
                        <tr>
                            <td>{{ $itemEntry->item->name }}</td>
                            <td>{{ $itemEntry->quantity }}</td>
                            <td>{{ number_format($itemEntry->price, 2) }}</td>
                            <td>{{ number_format($itemEntry->quantity * $itemEntry->price, 2) }}</td>
                        </tr>
                        @endforeach

                        @foreach ($quotation->quotationTotals as $totalEntry)
                        <tr>
                            <td colspan="3" style="text-align: right">{{ __($totalEntry->name) }} :</td>
                            <td>{{ number_format($totalEntry->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <table class="table table-bordered table-hover mt-5">

                <tr>
                    <th>Vendor Name</th>
                    <th>Account Name</th>
                    <th>FOB</th>
                    <th>Amount</th>
                    <th>Memo</th>
                </tr>

                @foreach ($quotation->quotationAccounts as $accountEntry)
                <tr>
                    <td>{{ $accountEntry->vendor->name }}</td>
                    <td>{{ $accountEntry->account->name }}</td>
                    <td>{{ $accountEntry->fob }}</td>
                    <td>{{ number_format($accountEntry->amount, 2) }}</td>
                    <td>{{ $accountEntry->memo }}</td>
                </tr>
                @endforeach

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
