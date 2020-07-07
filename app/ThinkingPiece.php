<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class ThinkingPiece extends Model
{
    //
	
	use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
}
