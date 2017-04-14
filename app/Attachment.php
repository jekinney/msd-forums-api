<?php

namespace App;

use Illuminate\Http\File;
use App\Google\FileStorage;
use Illuminate\Support\Facades\Storage;
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

    public function uploadFile($request)
    {
    	$upload = $request->file('file');
    	$name = str_slug(explode('.', $upload->getClientOriginalName())[0]);
    	$type = $upload->getClientOriginalExtension();

    	if(Storage::disk('gcs')->exists('forum/'. $upload->getClientOriginalName())) {
    		$name = $name.'-'.date('Y-m-d').'.'.$type;
    	} else {
    		$name = $name.'.'.$type;
    	}

    	$file = Storage::disk('gcs')->putFileAs('forum', $upload, $name, 'public');

    	return Storage::disk('gcs')->url($file);
    }
}
