<?php

namespace App\Catalog;

use Illuminate\Database\Eloquent\Model;

class Toy extends Model
{
    protected $guarded = [];

    public function vendor()
    {
    	return $this->belongsTo(Vendor::class);
    }
}
