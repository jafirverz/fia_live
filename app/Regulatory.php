<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Regulatory extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    protected $dates = [
        'date_of_regulation_in_force',
    ];

    public function scopeLatestRegulatory($query)
    {
        return $query->where('parent_id', '!=', null)->where('delete_status', NULL)->latest()->get();
    }

    public function scopeChildRegulatory($query, $id)
    {
        return $query->where('parent_id', $id)->where('delete_status', NULL)->orderBy('regulatory_date', 'desc')->get();
    }
}
