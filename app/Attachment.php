<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable = ['user_id', 'attachable_id', 'attachable_type', 'hidden'];

    /**
     * Get all of the owning attachable models.
     */
    public function attachable()
    {
        return $this->morphTo();
    }
}
