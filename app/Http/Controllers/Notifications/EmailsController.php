<?php

namespace App\Http\Controllers\Notifications;

use Carbon\Carbon;
use App\Notifications\Email;
use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\EmailForm;

class EmailsController extends Controller
{
    protected $email;

    function __construct(Email $email) 
    {
        $this->email = $email;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json($this->email->getAll());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailForm $request)
    {   
        
        $email = $this->email->create($this->setDataArray());
        $email->addRecipients(request('recipients'));

        return response([], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json($this->email->findByIdForShow($id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json($this->email->findByIdForEdit($id));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {   
        $email = $this->email->find($id);
        $email->update($this->setDataArray());
        $email->addRecipients(request('recipients'));

        return response([], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notifications\Email  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->email->destroy($id);

        return response()->json([], 200);
    }

    protected function setDataArray()
    {
        return [
            'subject' => request('subject'),
            'message' => request('message'),
            'send_at' => request('send_at')? Carbon::parse(request('send_at')):Carbon::now(),
            'send_now' => request('send_now')? true:false
        ];
    }
}
