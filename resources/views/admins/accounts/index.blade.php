@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Accounts Table</h3>
                
                <div class="card-tools">
                    <a href="{{ route('admin.accounts.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
                </div>
            </div>
            <!-- /.card-header -->
        
            <div class="card-body">
                @include ('admins/accounts/partials/accountTable', ['accounts' => $accounts])
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endsection
