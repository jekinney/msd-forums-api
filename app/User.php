<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nav_id', 'name', 'email', 'company', 'type', 'job', 'banned',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function replies()
    {
        return $this->hasMany(Thread::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function updateOrCreate($request)
    {
        if($user = $this->where('nav_id', $request->no)->first()) {
            $user->update($this->setDataArray($request));
            return $user;
        }

        return $this->create($this->setDataArray($request)); 
    }

    protected function setDataArray($request)
    {
        return [
            'nav_id' => $request->no,
            'name' => $request->name,
            'email' => $request->email,
            'company' => $request->company,
            'type' => $request->type,
            'job' => $request->job,
        ];
    }
}
