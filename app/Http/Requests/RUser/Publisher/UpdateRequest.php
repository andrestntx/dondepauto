<?php


namespace App\Http\Requests\RUser\Publisher;

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
        $publisher = $this->route->getParameter('publishers');
        $rules = $this->storeRequest->rules();

        $rules['email']         .= ',' . $publisher->id . ',id_us_LI';
        $rules['first_name']    = 'required';
        $rules['last_name']     = 'required';
        $rules['phone']			= 'required';
        $rules['cel']			= 'required';
        //$rules['company_nit']	= 'required';
        $rules['company_role']	= 'required';
        $rules['city_id']		= 'required';
        //$rules['address']		= 'required';

        return $rules;
    }
}