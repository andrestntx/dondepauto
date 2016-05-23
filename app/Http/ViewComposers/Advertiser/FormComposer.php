<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/04/2016
 * Time: 9:39 AM
 */

namespace App\Http\ViewComposers\Advertiser;

use App\Repositories\Platform\CityRepository;
use App\Repositories\Platform\EconomicActivityRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;

class FormComposer
{
    protected  $adviserRepository;
    protected $cityRepository;

    function __construct(UserRepository $adviserRepository, CityRepository $cityRepository, EconomicActivityRepository $economicActivityRepository)
    {
        $this->adviserRepository = $adviserRepository;
        $this->cityRepository = $cityRepository;
        $this->economicActivityRepository = $economicActivityRepository;
    }

    public function compose(View $view)
    {
        $advisers = $this->adviserRepository->listsSelectAdvisers();
        $cities = $this->cityRepository->listsSelect();
        $activities =  $this->economicActivityRepository->listsSelect();
        
        $view->with([
            'advisers'  => $advisers,
            'cities'    => $cities,
            'activities' => $activities
        ]);
    }
}