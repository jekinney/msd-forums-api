<?php

namespace App\Catalog;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
   	protected $guarded = [];

   	public function representative()
   	{
	   	return $this->belongsTo(Representative::class);
   	}

  	public function data() 
  	{
  		return $this->hasMany(VendorData::class, 'id', 'vendor_id');
  	}

  	public function toys() 
  	{
  		return $this->hasMany(Toy::class)
  	}
}
