<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regulatory extends Model
{
    protected $dates = [
        'date_of_regulation_in_force',
    ];
}
