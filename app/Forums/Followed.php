<?php

namespace App\Forums;

use Illuminate\Database\Eloquent\Model;

class Followed extends Model
{
    protected $fillable = ['user_id', 'followable_id', 'followable_type'];

    /**
     * Get all of the owning followable models.
     */
    public function followable()
    {
        return $this->morphTo();
    }
}
