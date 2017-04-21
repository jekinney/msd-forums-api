<?php

namespace App\Http\Controllers;

use Storage;
use App\Attachment;
use App\Fractal\Attachments;
use Illuminate\Http\Request;

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
    public function storeFiles(Request $request, Attachment $attachment)
    {
        $location = $attachment->uploadFiles($request);

        return response()->json($location);
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

        $attachments = Attachment::where('attachable_id', $file->attachable_id)->where('attachable_type', $file->attachable_type)->get();

        $file->delete();

        return fractal($attachments, new Attachments)->respond();
    }
}
