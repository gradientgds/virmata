@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hover Data Table</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.items.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                
                <p>Item SKU: {{ $item->sku }}</p>
                <p>Item Name: {{ $item->name }}</p>

                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>Stock</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $stock = 0 ?>
                        @foreach ($item->historyItems() as $historyItem)
                        <tr>
                            <td>{{ get_class($historyItem) }}</td>
                            <td>{{ (get_class($historyItem) == App\Models\Admin\Purchase\PurchaseInvoiceItem::class ? $historyItem->purchaseInvoice->id : $historyItem->salesInvoice->id) }}</td>
                            <td>{{ (get_class($historyItem) == App\Models\Admin\Purchase\PurchaseInvoiceItem::class ? $historyItem->purchaseInvoice->date : $historyItem->salesInvoice->date) }}</td>
                            <td>{{ $historyItem->quantity }}</td>
                            <td>{{ (get_class($historyItem) == App\Models\Admin\Purchase\PurchaseInvoiceItem::class ? $stock += $historyItem->quantity : $stock -= $historyItem->quantity) }}</td>
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
