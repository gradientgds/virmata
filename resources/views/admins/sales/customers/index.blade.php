@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Customers</h3>

                <div class="card-tools">
                <a href="{{ route('admin.sales.customers.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address (RAW)</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>
                            <a href="{{ route('admin.sales.customers.show', $customer->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                            <a href="{{ route('admin.sales.customers.show', $customer->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                            <a href="{{ route('admin.sales.customers.show', $customer->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
                        </td>
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
