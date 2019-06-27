<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TopicalReportCountry extends Model
{
    //
	use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
	public $timestamps = false;
}
