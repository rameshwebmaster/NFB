<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePanelUser extends FormRequest
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
            'username' => 'required|alpha_dash|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'image',
            'password' => 'required|min:6|alpha_num',
            'role' => 'required',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'gender' => 'required'
        ];
    }
}
