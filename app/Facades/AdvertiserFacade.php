<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 15/04/2016
 * Time: 9:03 AM
 */

namespace App\Facades;

use App\Entities\User;
use App\Entities\Platform\User as Advertiser;
use App\Services\AdvertiserService;
use App\Services\ConfirmationService;
use App\Services\ContactService;
use App\Services\EmailService;
use App\Services\MailchimpService;
use App\Services\MixpanelService;
use App\Services\ProposalService;
use App\Services\UserService;
use App\Services\Platform\UserService as UserPlatformService;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdvertiserFacade extends UserFacade
{
    protected $advertiserService;
    protected $emailService;
    protected $confirmationService;
    protected $mixpanelService;
    protected $mailchimpService;
    protected $userService;

    public function __construct(AdvertiserService $advertiserService, EmailService $emailService, 
                                ConfirmationService $confirmationService, MixpanelService $mixpanelService,
                                MailchimpService $mailchimpService, ProposalService $proposalService, UserService $userService,
                                ContactService $contactService, UserPlatformService $userPlatformService)
    {
        $this->advertiserService = $advertiserService;
        $this->emailService = $emailService;
        $this->confirmationService = $confirmationService;
        $this->mixpanelService = $mixpanelService;
        $this->mailchimpService = $mailchimpService;
        $this->proposalService = $proposalService;
        $this->userService = $userService;;

        parent::__construct($userPlatformService, $contactService);
     }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function advertisersWithOutAdviser()
    {
        return $this->advertiserService->advertisersWithOutAdviser();
    }

    /**
     * @param User|null $user
     * @param array $columns
     * @param array $search
     * @param null $intentionsInit
     * @param null $intentionsFinish
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $user = null, array $columns, array $search, $intentionsInit = null, $intentionsFinish = null)
    {
        return $this->advertiserService->search($user, $columns, $search, $intentionsInit, $intentionsFinish);
    }

    /**
     * @param Advertiser $user
     * @return mixed
     */
    public function getAdvertiser(Advertiser $user)
    {
        return $this->advertiserService->getAdvertiserView($user);
    }

    /**
     * @param Advertiser $advertiser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchProposals(Advertiser $advertiser)
    {
        return $this->proposalService->search($advertiser);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $advertiser = $this->advertiserService->createModel($data);
        $confirmation = $this->confirmationService->generateConfirmation($advertiser);
        $this->emailService->sendAdvertiserInvitation($advertiser, $confirmation->code);
        $this->mixpanelService->registerUser($advertiser);
        $this->mailchimpService->syncAdvertiser($advertiser);
        
        return $advertiser;
    }

    /**
     * @param array $data
     */
    public function createAdvertiser(array $data)
    {
        $publisher = $this->createModel($data);
        $this->createContact($publisher, $data);
    }

    /**
     * @param array $data
     * @param Advertiser $advertiser
     * @return \App\Entities\Platform\User|mixed
     */
    public function updateModel(array $data, Advertiser $advertiser)
    {
        $advertiser = $this->advertiserService->updateModel($data, $advertiser);
        $this->mixpanelService->updateAdvertiser($advertiser);
        $this->mailchimpService->syncAdvertiser($advertiser);

        return $advertiser;
    }

    /**
     * @param array $data
     * @param Advertiser $advertiser
     * @return mixed
     */
    public function updateModelView(array $data, Advertiser $advertiser)
    {
        return $this->advertiserService->getAdvertiserView($this->updateModel($data, $advertiser));
    }


    /**
     * @param Advertiser $advertiser
     */
    public function changeRole(Advertiser $advertiser)
    {
        $this->advertiserService->changeRole($advertiser);
        $user = $advertiser->user;
        if(is_null($advertiser->user)) {
            $user = $this->userService->createUserOfAdvertiser($advertiser);
        }
        $this->userService->changeRole($user, 'publisher');
        $this->mixpanelService->updateRoleUser($advertiser);
        $this->mailchimpService->updateRoleUser($advertiser);
        $this->emailService->notifyChangePublisherRole($advertiser);
    }


    /**
     * @param Advertiser $advertiser
     */
    public function deleteAdvertiser(Advertiser $advertiser)
    {
        $this->emailService->notifyUserDelete($advertiser);
        $this->advertiserService->deleteModel($advertiser);
    }
}