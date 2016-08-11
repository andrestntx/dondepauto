<?php


namespace App\Http\Requests\RUser\Publisher;

use App\Http\Requests\Request;

class CompleteRequest extends Request
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
            'phone'			=> 'required',
            'cel'			=> 'required',
            'company_nit'	=> '',
            'company_role'	=> 'required',
            'city_id'		=> 'required',
            'address'		=> 'required',
            'password'      => 'required|confirmed'
        ];
    }
}