<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;
class Podcast extends Model
{
    //
	
	use LogsActivity;
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
	
	public function scopeSearch($query, $search_term)
    {
        
		if($search_term->topical_id!="")
		$query->where('podcasts.topical_id', 'like', '%'.$search_term->topical_id.'%');
		
		if($search_term->keyword!="")
		$query->where('podcasts.title', 'like', '%'.$search_term->keyword.'%');
		
		if($search_term->keyword!="")
		$query->orWhere('podcasts.description','like', '%'.$search_term->keyword.'%');  
		
        return $query;
    }
}
