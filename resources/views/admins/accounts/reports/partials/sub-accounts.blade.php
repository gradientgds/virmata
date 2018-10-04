@foreach ($accounts as $account)

    @if ($account->subAccounts->count())
        <tr style="font-weight: bold;">
    @else
        <tr>
    @endif

    @php
        $indent = 15 * $level;
    @endphp
            <td style="padding-left: {{ $indent }}px">{{ $account->number }}</td>
            <td style="padding-left: {{ $indent }}px">{{ $account->name }}</td>
            <td style="text-align: right">{{ number_format(abs($account->totalAll()), 2) }}</td>
        </tr>

    @include ('admins/accounts/reports/partials/sub-accounts', ['accounts' => $account->subAccounts()->orderBy('number', 'asc')->get(), 'level' => $level+1])

@endforeach
