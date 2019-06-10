<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Banner extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function page()
    {
        return $this->belongsTo('App\Page'); // links this->id to events.course_id
    }
}
