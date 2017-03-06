<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppUser extends FormRequest
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
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'gender' => 'required|in:1,2',
            'type' => 'required|in:gold,platinum',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
            'phone_number' => 'numeric',
            'country' => 'required',
            'birth_date' => 'date',
            'language' => 'required'
        ];
    }
}
