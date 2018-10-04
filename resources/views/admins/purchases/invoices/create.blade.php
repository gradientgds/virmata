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
			<form role="form" method="POST" action="{{ route('admin.purchases.invoices.store') }}">
			@csrf
				<div class="card-body">

					<div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', now()->addWeek()->format('Y-m-d')) }}">
                    </div>
					
					<div class="form-group">
                        <label for="vendor_id">Vendor</label>
                        <select class="form-control select2" id="vendor_id" name="vendor_id">
                            <option value="">-- Pick One --</option>
                            @foreach ($vendors as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                            <div class="checkbox">
                                <label for="ppn">
                                <input type="checkbox" id="ppn" name="ppn" value="1"> PPN</label>
                            </div>

                            <div classs="checkbox">
                                <label for="ppn_included">
                                <input type="checkbox" id="ppn_included" name="ppn_included" value="1"> PPN Included</label>
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
                            @for ($i=0; $i < 10; $i++)
                            <tr>
                                <td>
                                    <select class="form-control select2" name="invoiceItemRows[item_id][]" style="width: 100%">
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
                                <td colspan="3" style="text-align:right">{{ __('purchases.invoices.sub_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[sub_total]">SUBTOTAL</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right; vertical-align:middle">{{ __('purchases.invoices.discount') }} :</td>
                                <td><input type="number" class="form-control" name="invoiceTotalRows[discount]"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('purchases.invoices.tax_ppn') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[tax_ppn]">PPN 10%</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('purchases.invoices.item_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[item_total]">ITEM TOTAL</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('purchases.invoices.account_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[account_total]">ACCOUNT TOTAL</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('purchases.invoices.grand_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="invoiceTotalRows[grand_total]">GRAND TOTAL</td>
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
