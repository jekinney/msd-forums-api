<?php

namespace App\Http\Requests\Forums;

use Illuminate\Foundation\Http\FormRequest;

class ReplyForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
            'thread_id' => 'required|numeric',
            'reply' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'user_id.required' => 'Application error, please refresh the page. If it coninutes please let us know',
            'thread_id.required' => 'Application error, please refresh the page. If it coninutes please let us know',
            'reply.required' => 'Your reply needs to have something!',
        ];
    }
}
