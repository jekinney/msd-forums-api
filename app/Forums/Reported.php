<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;

class Reported extends Model
{
	protected $table = 'reported';

    protected $fillable = ['reported_by', 'reportable_id', 'reportable_type'];

     /**
     * Get all of the owning attachable models.
     */
    public function reportable()
    {
    	return $this->morphTo();
    }
}
