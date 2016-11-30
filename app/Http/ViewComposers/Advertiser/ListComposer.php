<?php

namespace App\Http\ViewComposers\Advertiser;

use App\Repositories\Platform\ActionRepository;
use App\Repositories\Platform\CityRepository;
use App\Repositories\Platform\ContactRepository;
use App\Repositories\Platform\EconomicActivityRepository;
use App\Repositories\Platform\Space\AudienceRepository;
use App\Repositories\Platform\Space\AudienceTypeRepository;
use App\Repositories\Platform\TagRepository;
use App\Repositories\Proposal\QuestionRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\View\View;
use App\Http\ViewComposers\BaseComposer;

class ListComposer extends BaseComposer
{
    protected $cityRepository;
    protected $economicActivityRepository;
    protected $actionRepository;
    protected $contactRepository;
    protected $questionRepository;
    protected $audienceTypeRepository;
    protected $tagRepository;

    /**
     * ListComposer constructor.
     * @param UserRepository $repository
     * @param CityRepository $cityRepository
     * @param EconomicActivityRepository $economicActivityRepository
     * @param ActionRepository $actionRepository
     * @param ContactRepository $contactRepository
     * @param QuestionRepository $questionRepository
     * @param AudienceTypeRepository $audienceTypeRepository
     */
    function __construct(UserRepository $repository, CityRepository $cityRepository, EconomicActivityRepository $economicActivityRepository,
                         ActionRepository $actionRepository, ContactRepository $contactRepository, QuestionRepository $questionRepository,
                         AudienceTypeRepository $audienceTypeRepository, TagRepository $tagRepository)
    {
        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
        $this->economicActivityRepository = $economicActivityRepository;
        $this->actionRepository = $actionRepository;
        $this->contactRepository = $contactRepository;
        $this->questionRepository = $questionRepository;
        $this->audienceTypeRepository = $audienceTypeRepository;
        $this->tagRepository = $tagRepository;
    }
    
    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $registrationStates = \Lang::get('states.advertiser');
        $cities = $this->cityRepository->citiesWithAdvertisers();
        $economicActivities = $this->economicActivityRepository->activitiesWithAdvertisers();

        $actions = $this->actionRepository->model->where(function($query){
            $query->where('type', 'advertiser')
                ->orWhere('type', 'all')
                ->orWhere('type', 'none')
                ->orWhere('type', 'users');
        })->get();

        $tags           = $this->tagRepository->model->where('type', 'advertiser')->orWhere('type', 'all')->lists('name', 'id')->all();
        $actionsToday = $this->contactRepository->getCountActions('advertiser');
        $questions = $this->questionRepository->model->all();
        $audiences = $this->audienceTypeRepository->selectAudiences();


        $view->with([
            'registrationStates'    => $registrationStates,
            'cities'                => $cities,
            'economicActivities'    => $economicActivities,
            'actions'               => $actions,
            'actionsToday'          => $actionsToday,
            'questions'             => $questions,
            'audiences'             => $audiences,
            'tags'                  => $tags
        ]);
    }
}