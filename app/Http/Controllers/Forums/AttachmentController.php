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
    public function reply(Request $request)
    {
        return response()->json($this->attachment->uploadReplyFile($request));
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function thread(Request $request)
    {        
        return response()->json($this->attachment->uploadThreadFile($request));
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

        Storage::delete($file->full_path);

        $file->delete();

        return response()->json([], 200);
    }
}
