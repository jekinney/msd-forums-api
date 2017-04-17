<?php

namespace App\Http\Requests\Forums;

use Illuminate\Foundation\Http\FormRequest;

class ThreadForm extends FormRequest
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
            'channel_id' => 'required|numeric',
            'title' => 'required|max:191',
            'body' => 'required',
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
            'channel_id.required' => 'Select a channel',
            'title.required' => 'A title is required',
            'title.max' => 'The title is to long',
            'body.required'  => 'A thread body is required',
        ];
    }
}
