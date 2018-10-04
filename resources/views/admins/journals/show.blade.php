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
                <!-- <p>
					<a href="{{ route('admin.journals.create') }}"><button type="button" class="btn btn-primary">Create</button></a>
				</p> -->
            </div>
            <!-- /.box-header -->

            <div class="box-body table-responsive no-padding">

                <div class="form-group">
                    <p>Date: {{ $journal->date }}</p>
                    <p>Description: {{ $journal->description }}</p>
                </div>

                <table class="table table-hover">
                    <tr>
                        <th>Account Name</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Memo</th>
                    </tr>
                    @foreach ($journal->journalEntries as $entry)
                    <tr>
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

                    <tr style="font-weight:bold">
                        <td>Total:</td>
                        <td>{{ number_format($journal->sumDebit(), 2) }}</td>
                        <td>{{ number_format($journal->sumCredit(), 2) }}</td>
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
