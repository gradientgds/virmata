<tr>
    <td colspan="3" style="font-weight: bold; border-bottom: 1px solid black;">{{ $accountType->name }}</td>
</tr>

@foreach ($accountType->accounts as $account)

    @if ($account->parent_id == 0)

        @if ($account->subAccounts->count())

        <tr style="font-weight: bold;">
            <td>{{ $account->number }}</td>
            <td>{{ $account->name }}</td>
            <td style="text-align: right">{{ number_format(abs($account->totalAll()), 2) }}</td>
        </tr>

        @include ('admins/accounts/reports/partials/sub-accounts', ['accounts' => $account->subAccounts()->orderBy('number', 'asc')->get(), 'level' => 1])

        @else

        <tr>
            <td>{{ $account->number }}</td>
            <td>{{ $account->name }}</td>
            <td style="text-align: right">{{ number_format(abs($account->totalAll()), 2) }}</td>
        </tr>
            
        @endif
    @endif

@endforeach

@if ($accountType->id == 11)

<tr>
    <td>Profit/Loss</td>
    <td colspan="2" style="text-align: right; border-top: 1px solid black;">{{ number_format(abs($profitLoss), 2) }}</td>
</tr>

<tr style="font-weight: bold;">
    <td>Total {{ $accountType->name }}:</td>
    <td colspan="2" style="text-align: right; border-top: 1px solid black;">{{ number_format($accountType->total() + $profitLoss, 2) }}</td>
</tr>

@else

<tr style="font-weight: bold;">
    <td>Total {{ $accountType->name }}:</td>
    <td colspan="2" style="text-align: right; border-top: 1px solid black;">{{ number_format($accountType->total(), 2) }}</td>
</tr>

@endif
