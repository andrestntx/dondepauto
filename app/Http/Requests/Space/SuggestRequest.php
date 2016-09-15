<?php


namespace App\Http\Requests\Space;

use App\Http\Requests\Request;
use App\Http\Requests\RUser\StoreRequest as RUserStoreRequest;
use Illuminate\Routing\Route;

class SuggestRequest extends Request
{
    /**
     * @var Route
     */
    private $route;

    /**
     * UpdateRequest constructor.
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }
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
     * Get validation rules to suggest a Space
     * @return array
     */
    public function rules()
    {
        return [
            'advertisers'  => 'required|array'
        ];
    }
}