<?php


namespace App\Http\Requests\RUser\Publisher;

use App\Http\Requests\Request;
use App\Http\Requests\RUser\StoreRequest as RUserStoreRequest;
use Illuminate\Routing\Route;

class StoreRequest extends Request
{
    /**
     * @var Route
     */
    private $route;
    /**
     * @var RUserStoreRequest
     */
    private $storeRequest;
    /**
     * UpdateRequest constructor.
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
        $this->storeRequest = new RUserStoreRequest;
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
     * Get validation rules to create a Occupation
     * @return array
     */
    public function rules()
    {
        $rules = $this->storeRequest->rules();
        $rules['password'] = 'confirmed';
        $rules['email'] = 'required|unique:us_reg_LIST,email_us_LI,NULL,id_us_LI,deleted_at,NULL';

        return $rules;
    }
}