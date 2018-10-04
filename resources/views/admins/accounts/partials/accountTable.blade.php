<table id="example1" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>Number</th>
        <th>Name</th>
        <th>Type</th>
        <th>Saldo</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($accounts as $account)

        @if ($account->subAccounts->count())

        <tr style="font-weight: bold;">
            <td><a href="{{ route('admin.accounts.edit', $account->id) }}">{{ $account->id }}</a></td>
            <td>{{ $account->number }}</td>
            <td>{{ $account->name }}</td>
            <td>{{ $account->accountType->name }}</td>
            <td>{{ number_format($account->totalAll(), 2) }}</td>
        </tr>

        @include ('admins/accounts/partials/accountTablePartial', ['accounts' => $account->subAccounts()->orderBy('number')->get(), 'level' => 1])

        @else

        <tr>
            <td>{{ $account->id }}</td>
            <td>{{ $account->number }}</td>
            <td>{{ $account->name }}</td>
            <td>{{ $account->accountType->name }}</td>
            <td>{{ number_format($account->totalAll(), 2) }}</td>
            <td>
                <a href="{{ route('admin.accounts.show', $account->id) }}"><button class="btn btn-default"><i class="fa fa-eye fa-fw"></i></button></a>
                <a href="{{ route('admin.accounts.edit', $account->id) }}"><button class="btn btn-default"><i class="fa fa-edit fa-fw"></i></button></a>
                <a href="{{ route('admin.accounts.show', $account->id) }}"><button class="btn btn-default"><i class="fa fa-trash fa-fw"></i></button></a>
            </td>
        </tr>
            
        @endif

    @endforeach
    </tbody>
</table>