<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MasterSetting extends Model
{
    use LogsActivity;

    protected $table = 'master_setting';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;


}
