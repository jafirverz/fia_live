<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Filter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

}
