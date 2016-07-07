<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:48 AM
 */

namespace App\Facades;

use App\Entities\Platform\User;
use App\Services\ConfirmationService;
use App\Services\EmailService;
use App\Services\MailchimpService;
use App\Services\PasswordService;
use App\Services\UserService;
use App\Services\PublisherService;
use App\Services\MixpanelService;
use App\Services\Space\SpaceService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PublisherFacade
{
    protected $service;
    protected $emailService;
    protected $spaceService;
    protected $confirmationService;
    protected $mixpanelService;
    protected $mailchimpService;
    protected $passwordService;
    protected $userService;

    public function __construct(PublisherService $service, EmailService $emailService, UserService $userService,
                                ConfirmationService $confirmationService, MixpanelService $mixpanelService,
                                MailchimpService $mailchimpService, SpaceService $spaceService, PasswordService $passwordService)
    {
        $this->service = $service;
        $this->emailService = $emailService;
        $this->confirmationService = $confirmationService;
        $this->mixpanelService = $mixpanelService;
        $this->mailchimpService = $mailchimpService;
        $this->spaceService = $spaceService;
        $this->passwordService = $passwordService;
        $this->userService = $userService;
    }

    /**
     * @param User $publisher
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchSpaces(User $publisher)
    {
        return $this->spaceService->search($publisher);
    }


    /**
     * @param array $columns
     * @param array $search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(array $columns, array $search)
    {
        return $this->service->search($columns, $search);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $publisher = $this->service->createModel($data);
        $confirmation = $this->confirmationService->generateConfirmation($publisher);
        $this->emailService->sendPublisherInvitation($publisher, $confirmation->code);
        //$this->mixpanelService->registerUser($publisher);
        $this->mailchimpService->syncPublisher($publisher);
        
        return $publisher;
    }

    /**
     * @param array $data
     * @param Model $publisher
     * @return mixed
     */
    public function updateModel(array $data, Model $publisher)
    {
        $publisher = $this->service->updateModel($data, $publisher);
        //$this->mixpanelService->updatePublisher($publisher);
        $this->mailchimpService->syncPublisher($publisher);

        return $publisher;
    }

    /**
     * @param array $data
     * @param Model $publisher
     * @return Model|mixed
     */
    public function completeData(array $data, Model $publisher)
    {
        $publisher = $this->service->completeData($data, $publisher);
        //$this->mixpanelService->updatePublisher($publisher);
        $this->mailchimpService->syncPublisher($publisher);

        return $publisher;
    }

    public function getSpaces(Model $publisher)
    {
        return $this->service->getSpaces($publisher);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function registerAutoPassword(array $data)
    {
        $password   = $this->passwordService->generate();
        $data       = $this->userService->divideName($data);
        $publisher  = $this->service->register($data, $password);
        $user       = $this->userService->createPublisher($data, $password, $publisher);
        
        //$this->mixpanelService->registerUser($user);
        $confirmation = $this->confirmationService->generateConfirmation($publisher);
        $this->emailService->sendPublisherInvitation($publisher, $confirmation->code);
        
        return $user;
    }


    /**
     * @param $code
     * @return User|bool
     */
    public function confirm($code)
    {
        $publisher = $this->confirmationService->verifyAndConfirm($code);
        Auth::loginUsingId($publisher->user->id);
        
        return $publisher;
    }
    
}