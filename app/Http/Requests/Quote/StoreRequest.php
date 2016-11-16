<?php

/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/20/16
 * Time: 3:57 PM
 */

namespace App\Http\Requests\Quote;

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
    public function rules()
    {
        return [
            'questions'     => 'required|array',
            'cities'        => 'required|array',
        ];
    }
}