<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class Page extends Model
{
    //
	use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
}
