<?php

namespace App\Forums;

use App\User;
use App\Forums\Collections\ThreadList;
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

    public function toggle($model, $userId)
    {
    	if($model->followed()->where('user_id', $userId)->exists()) {
    		$model->followed()->where('user_id', $userId)->delete();
    	} else {
    		$model->followed()->create(['user_id' => $userId]);
    	}
    	return User::find($userId);
    }
}
