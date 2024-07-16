<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request()->isMethod('post')) {
            return [
                
                'body' => 'required|string',
            ];
        } else {
            return [
                
                'body' => 'required|string',
                
            ];
        }
    }

    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                
                'body.required' => 'Descritpion is required!'
            ];
        } else {
            return [
                
                'body.required' => 'Descritpion is required!'
            ];   
        }
    }
}
