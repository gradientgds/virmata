@extends('layouts.adminlte3.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hover Data Table</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Account Name</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Memo</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($journalEntries as $entry)
            <tr>
                <td>{{ $entry->journalable->date }}</td>
                <td>{{ $entry->journalable->id }}</td>
                <td>{{ $entry->account->name }}</td>
                <td>
                @if($entry->debit_credit == 'debit')
                    {{ number_format($entry->amount, 2) }}
                @endif
                </td>
                <td>
                @if($entry->debit_credit == 'credit')
                    {{ number_format($entry->amount, 2) }}
                @endif
                </td>
                <td>{{ $entry->memo }}</td>
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
