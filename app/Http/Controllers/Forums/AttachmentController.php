<?php

namespace App\Http\Controllers\Forums;

use Storage;
use App\Forums\Attachment;
use Illuminate\Http\Request;
use App\Forums\Fractal\Attachments;
use App\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImage(Request $request, Attachment $attachment)
    {
        $location = $attachment->uploadImage($request);

        return response()->json(['location' => $location]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, Attachment $attachment)
    {
        $threadId = $attachment->uploadReplyFile($request);

        return response()->json(['thread' => $threadId]);
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function thread(Request $request, Attachment $attachment)
    {        
        $threadId = $attachment->uploadThreadFile($request);

        return response()->json(['thread' => $threadId]);
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
