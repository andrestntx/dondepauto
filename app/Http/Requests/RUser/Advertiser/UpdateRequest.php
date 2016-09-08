<?php


namespace App\Http\Requests\RUser\Advertiser;

use App\Http\Requests\Request;
use Illuminate\Routing\Route;

class UpdateRequest extends Request
{
    /**
     * @var Route
     */
    private $route;
    /**
     * @var StoreRequest
     */
    private $storeRequest;
    /**
     * UpdateRequest constructor.
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
        $this->storeRequest = new StoreRequest($route);
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
    public function rules() {
        $advertiser = $this->route->getParameter('advertisers');
        $rules = $this->storeRequest->rules();

        $rules['email'] =  'required|unique:us_reg_LIST,email_us_LI,' . $advertiser->id . ',id_us_LI';

        return $rules;
    }
}