<?php

namespace App\Http\Controllers\Forums;

use Storage;
use App\Forums\Attachment;
use Illuminate\Http\Request;
use App\Forums\Fractal\Attachments;
use App\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    protected $attachment;

    function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request)
    {
        $location = $this->attachment->uploadImage($request);

        return response()->json(['location' => $location]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply($replyId)
    {
        return response()->json($this->attachment->findByReplyId($replyId));
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function thread($threadId)
    {        
        return response()->json($this->attachment->findByThreadId($threadId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Attachment $attachment)
    {
        $file = $attachment->find($id);
        $attachableId = $file->attachable_id;
        $attachableType = $file->attachable_type;
        Storage::delete($file->full_path);
        $file->delete();

        return fractal($attachments = Attachment::where('attachable_id', $attachableId)->where('attachable_type', $attachableType)->get(), new Attachments)->respond();
    }
}
