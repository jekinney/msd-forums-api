<?php

namespace App\Forums;

use App\Forums\Reply;
use App\Forums\Thread;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use App\Forums\Collections\AttachmentsList;

class Attachment extends Model
{
	protected $fillable = ['user_id', 'name', 'file_type', 'full_path', 'attachable_id', 'attachable_type', 'hidden',];

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
     * Upload files as attachments to thread model
     */
    public function uploadThreadFile($request)
    {
        $file = $request->file('attachment');
        $name = $this->setUniqueFileName($file);
        $path = $file->storeAs('public/attachments/forums',  $name);

        Thread::find($request->id)->attachments()->create([
            'name' => $name, 
            'full_path' => $path,
            'file_type' => $this->setFileType($file),
        ]); 

        return $request->id;
    }


    /**
    * Upload files as attachments to a reply
    */
    public function uploadReplyFile($request)
    {
        $file = $request->file('attachment');
        $name = $this->setUniqueFileName($file);
        $path = $file->storeAs('public/attachments/forums',  $name);

        Reply::find($request->id)
            ->attachments()->create([
                'name' => $name, 
                'full_path' => $path,
                'file_type' => $this->setFileType($request->file('attachment')),
            ]);
        
        return $request->id;
    }

    public function findByThreadId($threadId) 
    {
        $thread = Thread::with('attachments')->find($threadId);

        $attachList = new AttachmentsList();

        return $attachList->reply($thread->attachments);
    }

       public function findByReplyId($replyId) 
    {
        $reply = Reply::with('attachments')->find($replyId);

        $attachList = new AttachmentsList();

        return $attachList->reply($reply->attachments);
    }

    protected function setUniqueFileName($file)
    {
        $name = str_slug(explode('.', $file->getClientOriginalName())[0]);

        if(Storage::exists('public/attachments/forums/'.$name.'.'.$file->getClientOriginalExtension())) {
            return $name = str_random(5).$name.'.'.$file->getClientOriginalExtension();
        }

        return $name. '.' .$file->getClientOriginalExtension();
    }

    protected function setFileType($file)
    {
        $types = explode('/', $file->getMimeType());
        $type = $file->getClientOriginalExtension();

        if($types[0] == 'image') {
            return 'image';
        } elseif(preg_match('/xl/', $type)) {
            return 'excel';
        } elseif(preg_match('/pdf/', $type)) {
            return 'pdf';
        } elseif(preg_match('/do/', $type)) {
            return 'word';
        } elseif(preg_match('/txt/', $type)) {
            return 'text';
        } elseif(preg_match('/pp/', $type) || preg_match('/po/', $type) || preg_match('/sl/', $type)) {
            return 'pp';
        } else {
            return 'unkown';
        }
    }
}
