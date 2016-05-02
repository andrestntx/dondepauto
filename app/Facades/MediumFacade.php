<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:48 AM
 */

namespace App\Facades;

use App\Services\ConfirmationService;
use App\Services\EmailService;
use App\Services\MailchimpService;
use App\Services\MediumService;
use App\Services\MixpanelService;
use Illuminate\Database\Eloquent\Model;

class MediumFacade
{
    protected $service;
    protected $emailService;
    protected $confirmationService;
    protected $mixpanelService;
    protected $mailchimpService;

    public function __construct(MediumService $service, EmailService $emailService, 
                                ConfirmationService $confirmationService, MixpanelService $mixpanelService,
                                MailchimpService $mailchimpService)
    {
        $this->service = $service;
        $this->emailService = $emailService;
        $this->confirmationService = $confirmationService;
        $this->mixpanelService = $mixpanelService;
        $this->mailchimpService = $mailchimpService;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search()
    {
        return $this->service->search();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $medium = $this->service->createModel($data);
        $confirmation = $this->confirmationService->generateConfirmation($medium);
        $this->emailService->sendMediumInvitation($medium, $confirmation->code);
        //$this->mixpanelService->registerUser($medium);
        $this->mailchimpService->syncMedium($medium);
        
        return $medium;
    }

    /**
     * @param array $data
     * @param Model $medium
     * @return mixed
     */
    public function updateModel(array $data, Model $medium)
    {
        $medium = $this->service->updateModel($data, $medium);
        //$this->mixpanelService->updateMedium($medium);
        $this->mailchimpService->syncMedium($medium);

        return $medium;
    }
    
}