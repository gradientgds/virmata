<?php

namespace App\Models\Admin\Accounting;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function subAccounts()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function sumDebit()
    {
        $total = 0;
        foreach ($this->journalEntries as $entry)
        {
            if ($entry->debit_credit == 'debit')
            {
                $total += $entry->amount;
            }            
        }

        return $total;
    }

    public function sumCredit()
    {
        $total = 0;
        foreach ($this->journalEntries as $entry)
        {
            if ($entry->debit_credit == 'credit')
            {
                $total += $entry->amount;
            }
        }

        return $total;
    }

    public function total()
    {
        return $this->sumDebit() - $this->sumCredit();
    }

    public function totalAll()
    {
        $total = 0;
        
        if (sizeof($this->subAccounts))
        {
            foreach ($this->subAccounts as $subAccount)
            {
                $total += $subAccount->totalAll();
            }
        }
        else
        {
            $total = $this->total();
        }

        return $total;
    }
}
