<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function menu()
    {
        return $this->hasOne('App\Menu'); // links this->course_id to courses.id
    }

    public function banner()
    {
        return $this->hasOne('App\Banner'); // links this->course_id to courses.id
    }

    public function parent()
    {
        return Page::find($this->parent);
    }
}
