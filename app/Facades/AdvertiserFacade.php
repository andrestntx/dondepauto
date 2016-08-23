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
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdvertiserFacade
{
    protected $advertiserService;
    protected $emailService;
    protected $confirmationService;
    protected $mixpanelService;
    protected $mailchimpService;
    protected $userService;
    protected $contactService;

    public function __construct(AdvertiserService $advertiserService, EmailService $emailService, 
                                ConfirmationService $confirmationService, MixpanelService $mixpanelService,
                                MailchimpService $mailchimpService, ProposalService $proposalService, UserService $userService,
                                ContactService $contactService)
    {
        $this->advertiserService = $advertiserService;
        $this->emailService = $emailService;
        $this->confirmationService = $confirmationService;
        $this->mixpanelService = $mixpanelService;
        $this->mailchimpService = $mailchimpService;
        $this->proposalService = $proposalService;
        $this->userService = $userService;
        $this->contactService = $contactService;
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
     * @param Advertiser $advertiser
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchProposals(Advertiser $advertiser)
    {
        return $this->proposalService->search($advertiser);
    }


    /**
     * @param Advertiser $advertiser
     * @param array $data
     * @return mixed|null
     */
    public function createContact(Advertiser $advertiser, array $data)
    {
        if(array_key_exists('action', $data) && array_key_exists('comments', $data)) {
            $contact = $this->advertiserService->createContact($advertiser, $data['comments']);

            if( ! empty($data['action']['id'])) {
                $this->contactService->addAction($contact, $data['action']);
            }

            $contact->load('actions');

            return $contact;
        }

        return null;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $advertiser = $this->advertiserService->createModel($data);
        $this->createContact($advertiser, $data);
        $confirmation = $this->confirmationService->generateConfirmation($advertiser);
        $this->emailService->sendAdvertiserInvitation($advertiser, $confirmation->code);
        $this->mixpanelService->registerUser($advertiser);
        $this->mailchimpService->syncAdvertiser($advertiser);
        
        return $advertiser;
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