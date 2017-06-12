<?php

namespace App\Catalog;

use Illuminate\Database\Eloquent\Model;

class Represenative extends Model
{
    protected $guarded = [];

    public function vendor()
    {
    	return $this->hasMany(Vendor::class);
    }
}
