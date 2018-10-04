@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
        
            <div class="box-header">
                <!-- <h3 class="box-title">Responsive Hover Table</h3>

                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div> -->
                <p>
					<a href="{{ route('admin.purchases.vendors.create') }}"><button type="button" class="btn btn-primary">Create</button></a>
				</p>
            </div>
            <!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Account Name</th>
                        <th>Amount</th>
                        <th>Balance</th>
                    </tr>
                    @foreach ($vendor->purchasePayments as $purchasePayment)
                    <tr>
                        <td>{{ $purchasePayment->id }}</td>
                        <td>{{ $purchasePayment->account->name }}</td>
                        <td>{{ number_format($purchasePayment->accountPayables->sum('amount'), 2) }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
