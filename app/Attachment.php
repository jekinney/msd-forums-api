<?php

namespace App;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable = ['user_id', 'path', 'attachable_id', 'attachable_type', 'hidden'];

    /**
     * Get all of the owning attachable models.
     */
    public function attachable()
    {
        return $this->morphTo();
    }

    /**
     * Upload image from tinymce plugin
     */
    public function uploadImage($request)
    {
        return str_replace('public', '', $request->file('file')->store('public/images/forums'));
    }


    /**
    * Upload file (word, pdf, etc) attached to a thread or reply
    */
    public function uploadFiles($request)
    {
        $file = $request->file('attachment');

        $path = str_replace('public', '', $file->store('public/attachments/forums'));
        $class = studly_case($request->type);
        $class = new $class();
        $class->find($request->id)->attachments()->create(['path' => $path)]);
        
        return $class;
    }
}
