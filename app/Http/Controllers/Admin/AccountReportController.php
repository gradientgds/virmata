<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Accounting\AccountType;

class AccountReportController extends Controller
{
    public function balanceSheet()
    {
        $cashBank = AccountType::find(1);
        $accountReceivable = AccountType::find(2);
        $inventory = AccountType::find(3);
        $otherCurrentAsset = AccountType::find(4);

        $fixedAsset = AccountType::find(5);
        $accumulatedDepresiation = AccountType::find(6);
        $otherFixedAsset = AccountType::find(7);

        $currentDebt = AccountType::find(8);
        $otherCurrentDebt = AccountType::find(9);

        $longTermDebt = AccountType::find(10);

        $equity = AccountType::find(11);

        $income = AccountType::find(12);
        $cogs = AccountType::find(13);
        $expense = AccountType::find(14);
        
        $otherIncome = AccountType::find(15);
        $otherExpense = AccountType::find(16);

        $profitLoss = $income->total() - $cogs->total() - $expense->total() + $otherIncome->total() - $otherExpense->total();

        return view('admins.accounts.reports.balance-sheet', compact('cashBank', 'accountReceivable', 'inventory', 'otherCurrentAsset', 'fixedAsset', 'accumulatedDepresiation', 'otherFixedAsset', 'currentDebt', 'otherCurrentDebt', 'longTermDebt', 'equity', 'profitLoss'));
    }

    public function profitLoss()
    {
        $income = AccountType::find(12);
        $cogs = AccountType::find(13);
        $expense = AccountType::find(14);

        $otherIncome = AccountType::find(15);
        $otherExpense = AccountType::find(16);

        return view('admins.accounts.reports.profit-loss', compact('income', 'cogs', 'expense', 'otherIncome', 'otherExpense'));
    }
}
