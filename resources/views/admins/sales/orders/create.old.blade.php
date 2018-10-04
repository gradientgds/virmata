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
			<form role="form" method="POST" action="{{ route('admin.sales.orders.store') }}">
			@csrf
				<div class="card-body">

					<div class="form-group">
                        <label for="date">Date</label>
                        <datepicker-input name="date" value="{{ old('date', now()->format('d-m-Y')) }}"></datepicker-input>
                        <!-- <input type="text" class="form-control" id="datepicker" name="date" value="{{ old('date', now()->format('d-m-Y')) }}"> -->
                        <!-- <input type="date" class="form-control" name="date" value="{{ old('date', now()->format('Y-m-d')) }}"> -->
                    </div>

                    <!-- <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date', now()->addWeek()->format('Y-m-d')) }}">
                    </div> -->
					
					<div class="form-group">
                        <label>Customer</label>
                        <!-- <select-2-items name="customer_id"></select-2-items> -->
                        <select class="form-control select2" name="customer_id">
                            <option></option>
                            @foreach ($customers as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Seller</label>
                        <select class="form-control select2" name="seller_id">
                            <option></option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Shipping Service</label>
                        <select class="form-control select2" name="shipping_service_id">
                            <option></option>
                            @foreach ($shippingServices as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Marketplace</label>
                        <select class="form-control select2" name="marketplace_id">
                            <option></option>
                                @foreach ($marketplaces as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Marketplace Invoice Number</label>
                        <input type="number" class="form-control" name="marketplace_invoice_number" value="{{ old('marketplace_invoice_number') }}">
                    </div>

                    <div class="form-group">
                        <label>Accurate Invoice Number</label>
                        <input type="number" class="form-control" name="accurate_invoice_number" value="{{ old('accurate_invoice_number') }}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <input type="checkbox" id="ppn" name="ppn" value="1">
                            <label for="ppn">PPN</label>
                        </div>

                        <div class="checkbox">
                            <input type="checkbox" id="ppn_included" name="ppn_included" value="1">
                            <label for="ppn_included">PPN Included</label>
                        </div>
                    </div>

                    <testing-123 type="items"></testing-123>

					{{--<table id="example1" class="table table-bordered">
						<thead>
							<tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
							</tr>
						</thead>

						<tbody>
                            <tr>
                                <td>
                                    <select-2 type="users" name="itemRows[item_id][]"></select-2>
                                </td>
                                <td><input type="number" class="form-control" name="itemRows[quantity][]"></td>
                                <td><input type="number" class="form-control" name="itemRows[price][]"></td>
                                <td>TOTAL_PRICE</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('sales.invoices.sub_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="totalRows[sub_total]">SUBTOTAL</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right; vertical-align:middle">{{ __('sales.invoices.discount') }} :</td>
                                <td><input type="number" class="form-control" name="totalRows[discount]"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('sales.invoices.tax_ppn') }} :</td>
                                <td><input type="hidden" class="form-control" name="totalRows[tax_ppn]">PPN 10%</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right; vertical-align:middle">{{ __('sales.invoices.shipping_fee_income') }} :</td>
                                <td><input type="number" class="form-control" name="totalRows[shipping_fee_income]"></td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">{{ __('sales.invoices.grand_total') }} :</td>
                                <td><input type="hidden" class="form-control" name="totalRows[grand_total]">GRAND TOTAL</td>
                            </tr>
						</tbody>
					</table>--}}

                    <table id="example1" class="table table-bordered mt-5">
						<thead>
							<tr>
                                <th>Auto Deduct</th>
                                <th>Vendor</th>
                                <th>Account Name</th>
                                <th>Amount</th>
                                <th>Memo</th>
							</tr>
						</thead>

						<tbody>
                            @for ($i=0; $i < 10; $i++)
                            <tr>
                                <td><input type="checkbox" name="accountRows[fob][{{ $i }}]" value="1"></td>
                                <td>
                                    <select class="form-control select2" name="accountRows[vendor_id][{{ $i }}]">
                                        <option></option>
                                        @foreach ($vendors as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control select2" name="accountRows[account_id][{{ $i }}]">
                                        <option></option>
                                        @foreach ($accounts as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="accountRows[amount][{{ $i }}]"></td>
                                <td><input type="text" class="form-control" name="accountRows[memo][{{ $i }}]"></td>
                            </tr>
                            @endfor
						</tbody>
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
