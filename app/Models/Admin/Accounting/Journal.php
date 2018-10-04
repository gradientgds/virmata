<?php

namespace App\Models\Admin\Accounting;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    public function journalEntries()
    {
        return $this->morphMany(JournalEntry::class, 'journalable');
    }

    public function accounts()
    {
        return $this->morphToMany(Account::class, 'journalable', 'journal_entries');
    }

    public function sumDebit()
    {
        return $this->journalEntries->where('debit_credit', 'debit')->sum('amount');
    }

    public function sumCredit()
    {
        return $this->journalEntries->where('debit_credit', 'credit')->sum('amount');
    }
}
