<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\Text;
use App\Http\Controllers\Controller;

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
    public function store(Request $request)
    {
        $text = $this->text->create($this->setDataArray());

        $this->addRecipients($text);

        return response([], 200);
    }

    /**
     * Call back url for confirmation messages
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmation()
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $text = $this->text->find($id);
        $text->update($this->setDataArray());
        $text->recipients()->each->delete();
        $this->addRecipients($text);

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

    protected function addRecipients($text)
    {
        foreach(request('recipients') as $person) {
            $text->recipients()->create([
                'name' => $person->name,
                'email' => $person->email,
                'phone' => $person->phone
            ]);
        }
    }
}
