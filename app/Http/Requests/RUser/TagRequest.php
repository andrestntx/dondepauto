<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 9/27/16
 * Time: 2:34 PM
 */

namespace App\Http\Requests\RUser;


use App\Http\Requests\Request;

class TagRequest extends Request
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
     * Get validation rules to create a Tag
     * @return array
     */
    public function rules()
    {
        return [
            'tag_id' => 'exists:tags,id'
        ];
    }

}