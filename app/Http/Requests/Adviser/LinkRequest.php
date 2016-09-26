<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 14/04/2016
 * Time: 4:46 PM
 */

namespace App\Http\Requests\Adviser;

use App\Http\Requests\Request;

class LinkRequest extends Request
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
        \Log::info('reglas link');

        return [
            //'advertisers'  => 'required|array'
        ];
    }
}