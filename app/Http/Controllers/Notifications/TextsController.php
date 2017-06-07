<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;
use App\Notifications\Text;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\TextForm;

class TextsController extends Controller
{
    protected $text;

    function __construct(Text $text)
    {
        $this->text = $text;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->text->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TextForm $request)
    {
        $text = $this->text->create($this->setDataArray());
        $text->addRecipients(request('recipients'));

        return response([], 200);
    }

    /**
     * Send Test messages
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        $this->text->sendTest();

        return response([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->text->findByIdForShow($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json($this->text->findByIdForEdit($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, TextForm $request)
    {
        $text = $this->text->find($id);
        $text->update($this->setDataArray());
        $text->addRecipients(request('recipients'));

        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $text = $this->text->find($id);
        $text->recipients()->each->delete();
        $text->delete();

        return response([], 200);
    }

    /**
     * Get all upcoming for display
     * transformed with fractal
     *
     * @return array
     */
    protected function setDataArray()
    {
        return [
            'message' => request('message'),
            'send_at' => request('send_at')? Carbon::parse(request('send_at')):Carbon::now(),
            'send_now' => request('send_now')
        ];
    }
}
