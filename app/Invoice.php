<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    public function items()
    {
        return $this->hasMany(Item::class, 'invoice_id');
    }
    public function user()
    {
        return User::find($this->user_id);

    }
}
