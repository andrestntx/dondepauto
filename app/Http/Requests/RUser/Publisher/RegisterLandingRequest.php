<?php


namespace App\Http\Requests\RUser\Publisher;

use App\Http\Requests\Request;

class RegisterLandingRequest extends Request
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
    public function rules()
    {
        return [
            'name'      => 'required|max:255',
            'email'     => 'required|email|max:255|unique:users',
            'company'   => 'required',
            'tel'       => 'required'
        ];
    }
}