@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Quick Example</h3>
			</div>
			<!-- /.card-header -->

			<!-- form start -->
			<form role="form" method="POST" action="{{ route('admin.sales.invoices.update', $invoice->id) }}">
			@csrf
			@method('PATCH')
				<div class="card-body">

					<div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $invoice->date) }}">
                    </div>

                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', $invoice->due_date) }}">
                    </div>
					
					<div class="form-group">
                        <label>Customer</label>
                        <select class="form-control" name="customer_id">
                            <option value="">-- Pick One --</option>
                            @foreach ($customers as $id => $name)
								@if ($invoice->customer->id == $id)
								<option value="{{ $id }}" selected="selected">{{ $name }}</option>
								@else
                                <option value="{{ $id }}">{{ $name }}</option>
								@endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                            <div class="checkbox">
                                <label for="ppn">
									@if ($invoice->ppn)
                                	<input type="checkbox" id="ppn" name="ppn" value="1" checked="checked"> PPN
									@else
									<input type="checkbox" id="ppn" name="ppn" value="1"> PPN
									@endif
								</label>
                            </div>

                            <div classs="checkbox">
                                <label for="ppn_included">
									@if ($invoice->ppn_included)
									<input type="checkbox" id="ppn_included" name="ppn_included" value="1" checked="checked"> PPN Included
									@else
                                	<input type="checkbox" id="ppn_included" name="ppn_included" value="1"> PPN Included
									@endif
								</label>
                            </div>
                        </div>

					<table id="example1" class="table table-bordered">
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
                                <td>
                                    <select class="form-control" name="invoiceItemRows[item_id][]">
                                    <option value="">-- Pick One --</option>
                                    @foreach ($items as $id => $name)
										@if ($invoiceItem->item->id == $id)
										<option value="{{ $id }}" selected="selected">{{ $name }}</option>
										@else
                                        <option value="{{ $id }}">{{ $name }}</option>
										@endif
                                    @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="invoiceItemRows[quantity][]" value="{{ $invoiceItem->quantity }}"></td>
                                <td><input type="number" class="form-control" name="invoiceItemRows[price][]" value="{{ $invoiceItem->price }}"></td>
                                <td>{{ number_format($invoiceItem->quantity * $invoiceItem->price, 2) }}</td>
                            </tr>
                            @endforeach

							@for ($i=0; $i < 10; $i++)
                            <tr>
                                <td>
                                    <select class="form-control" name="invoiceItemRows[item_id][]">
                                    <option value="">-- Pick One --</option>
                                    @foreach ($items as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="invoiceItemRows[quantity][]"></td>
                                <td><input type="number" class="form-control" name="invoiceItemRows[price][]"></td>
                                <td>TOTAL_PRICE</td>
                            </tr>
                            @endfor

                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('sales.invoices.sub_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[sub_total]">{{ number_format($invoice->sub_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right; vertical-align:middle">{{ __('sales.invoices.discount') }} :</td>
                                <td><input type="number" class="form-control" name="invoiceTotalRows[discount]" value="{{ $invoice->discount }}"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('sales.invoices.tax_ppn') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[tax_ppn]">{{ number_format($invoice->tax_ppn, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right; vertical-align:middle">{{ __('sales.invoices.shipping_fee_income') }} :</td>
                                <td><input type="number" class="form-control" name="invoiceTotalRows[shipping_fee_income]" value="{{ $invoice->shipping_fee_income }}"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('sales.invoices.grand_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[grand_total]">{{ number_format($invoice->grand_total, 2) }}</td>
                            </tr>
						</tbody>

						<tfoot>
							<!-- <tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr> -->
						</tfoot>
					</table>

                    <table id="example1" class="table table-bordered mt-5">
						<thead>
							<tr>
                                <th>Vendor</th>
                                <th>Account Name</th>
                                <th>Amount</th>
                                <th>Memo</th>
							</tr>
						</thead>

						<tbody>
                            @for ($i=0; $i < 10; $i++)
                            <tr>
                                <td>
                                    <select class="form-control select2" name="invoiceAccountRows[vendor_id][]">
                                    <option value="">-- Pick One --</option>
                                    @foreach ($vendors as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="invoiceAccountRows[account_id][]">
                                    <option value="">-- Pick One --</option>
                                    @foreach ($accounts as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="invoiceAccountRows[amount][]"></td>
                                <td><input type="text" class="form-control" name="invoiceAccountRows[memo][]"></td>
                            </tr>
                            @endfor
						</tbody>

						<tfoot>
							<!-- <tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
							</tr> -->
						</tfoot>
					</table>
				</div>
				<!-- /.card-body -->

				<div class="card-footer">
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
		<!-- /.card -->
	</div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
