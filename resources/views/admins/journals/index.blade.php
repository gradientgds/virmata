@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hover Data Table</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.journals.create') }}"><button class="btn btn-success btn-sm">Add New <i class="fa fa-plus fa-fw"></i></button></a>
				</div>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($journals as $journal)
                        <tr>
                            <td>{{ $journal->id }}</td>
                            <td>{{ $journal->date }}</td>
                            <td>{{ $journal->description }}</td>
                            <td>
                                <a href="{{ route('admin.journals.show', $journal->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                                <a href="{{ route('admin.journals.show', $journal->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                                <a href="{{ route('admin.journals.show', $journal->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
                            </td>
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
