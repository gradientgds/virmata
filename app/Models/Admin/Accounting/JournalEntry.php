<?php

namespace App\Models\Admin\Accounting;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function journalable()
    {
        return $this->morphTo();
    }
}
