@foreach ($accounts as $account)

    @if ($account->subAccounts->count())
        <tr style="font-weight: bold;">
    @else
        <tr>
    @endif
            <td><a href="{{ route('admin.accounts.edit', $account->id) }}">{{ $account->id }}</a></td>
            <td>{{ $account->number }}</td>
            <td>

            @for ($i = 0; $i < $level; $i++)
                =
            @endfor

            {{ $account->name }}
            
            </td>
            <td>{{ $account->accountType->name }}</td>
            <td>{{ number_format($account->totalAll(), 2) }}</td>
        </tr>

    @include ('admins/accounts/partials/accountTablePartial', ['accounts' => $account->subAccounts()->orderBy('number')->get(), 'level' => $level+1])

@endforeach
