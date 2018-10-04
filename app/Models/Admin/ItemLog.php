<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ItemLog extends Model
{
    public function sourceable()
    {
        return $this->morphTo();
    }

    public function targetable()
    {
        return $this->morphTo();
    }
}
