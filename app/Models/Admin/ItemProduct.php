<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ItemProduct extends Model
{
    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }
}
