<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdatePanelUser extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'username' => 'required|alpha_dash|unique:users,username,' . $request->segment(4),
            'email' => 'required|email|unique:users,email,' . $request->segment(4),
            'avatar' => 'image',
            'password' => 'min:6|alpha_num',
            'role' => 'required',
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'gender' => 'required'
        ];
    }
}
