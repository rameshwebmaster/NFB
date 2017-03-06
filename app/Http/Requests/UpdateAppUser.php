<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateAppUser extends FormRequest
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
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'gender' => 'required|in:1,2',
            'type' => 'required|in:gold,platinum',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
            'phone_number' => 'numeric',
            'country' => 'required',
            'birth_date' => 'date',
        ];
    }
}
