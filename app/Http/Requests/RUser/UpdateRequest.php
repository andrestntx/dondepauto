<?php


namespace App\Http\Requests\RUser;
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
        $this->storeRequest = new StoreRequest;
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
        $adviser = $this->route->getParameter('advisers');
        $rules = $this->storeRequest->rules();

        $rules['email'] .= ',email,' . $adviser->id . ',id';
        $rules['password'] = 'confirmed';

        return $rules;
    }
}