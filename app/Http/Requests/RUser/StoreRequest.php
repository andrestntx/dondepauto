<?php

namespace App\Http\Requests\RUser;
use App\Http\Requests\Request;

class StoreRequest extends Request
{
    /**
     * Determine if the users is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    /**
     * Get validation rules to create a Occupation
     * @return array
     */
    public function rules() {
        return [
            'first_name'    => 'required_without:name',
            'last_name'     => 'required_without:name',
            'email'         => 'required|unique:users',
            'password'      => 'required|confirmed'
        ];
    }
}