<?php

namespace App;
use App\TopicalReportCountry;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
class TopicalReport extends Model
{
    //
	
	use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
	
	public function topical_report_countries()
    {
        return $this->hasMany('App\TopicalReportCountry');
    }
}
