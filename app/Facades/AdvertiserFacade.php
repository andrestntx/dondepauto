<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 15/04/2016
 * Time: 9:03 AM
 */

namespace App\Facades;

use App\Entities\User;
use App\Services\AdvertiserService;
use App\Services\ConfirmationService;
use App\Services\EmailService;
use App\Services\MailchimpService;
use App\Services\MixpanelService;
use Illuminate\Database\Eloquent\Model;

class AdvertiserFacade
{
    protected $advertiserService;
    protected $emailService;
    protected $confirmationService;
    protected $mixpanelService;
    protected $mailchimpService;

    public function __construct(AdvertiserService $advertiserService, EmailService $emailService, 
                                ConfirmationService $confirmationService, MixpanelService $mixpanelService,
                                MailchimpService $mailchimpService)
    {
        $this->advertiserService = $advertiserService;
        $this->emailService = $emailService;
        $this->confirmationService = $confirmationService;
        $this->mixpanelService = $mixpanelService;
        $this->mailchimpService = $mailchimpService;
     }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function advertisersWithOutAdviser()
    {
        return $this->advertiserService->advertisersWithOutAdviser();
    }

    /**
     * @param User $user
     * @param null $intentionsInit
     * @param null $intentionsFinish
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $user = null, $intentionsInit = null, $intentionsFinish = null)
    {
        return $this->advertiserService->search($user, $intentionsInit, $intentionsFinish);
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
        //$this->mixpanelService->registerUser($advertiser);
        $this->mailchimpService->syncAdvertiser($advertiser);
        
        return $advertiser;
    }

    /**
     * @param array $data
     * @param Model $advertiser
     * @return \App\Entities\Platform\User|mixed
     */
    public function updateModel(array $data, Model $advertiser)
    {
        $advertiser = $this->advertiserService->updateModel($data, $advertiser);
        //$this->mixpanelService->updateAdvertiser($advertiser);
        $this->mailchimpService->syncAdvertiser($advertiser);

        return $advertiser;
    } 
}