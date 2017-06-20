<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 15/04/2016
 * Time: 9:03 AM
 */

namespace App\Facades;

use App\Entities\Proposal\Quote;
use App\Entities\User;
use App\Entities\Platform\User as Advertiser;
use App\Services\AdvertiserService;
use App\Services\ConfirmationService;
use App\Services\ContactService;
use App\Services\EmailService;
use App\Services\FilterCollectionService;
use App\Services\MailchimpService;
use App\Services\MixpanelService;
use App\Services\ProposalService;
use App\Services\QuoteService;
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
    protected $quoteService;
    protected $proposalService;
    protected $filterCollectionService;

    public function __construct(AdvertiserService $advertiserService, EmailService $emailService, 
                                ConfirmationService $confirmationService, MixpanelService $mixpanelService,
                                MailchimpService $mailchimpService, ProposalService $proposalService, UserService $userService,
                                ContactService $contactService, UserPlatformService $userPlatformService, QuoteService $quoteService,
                                FilterCollectionService $filterCollectionService)
    {
        $this->advertiserService = $advertiserService;
        $this->emailService = $emailService;
        $this->confirmationService = $confirmationService;
        $this->mixpanelService = $mixpanelService;
        $this->mailchimpService = $mailchimpService;
        $this->proposalService = $proposalService;
        $this->userService = $userService;
        $this->quoteService = $quoteService;
        $this->proposalService = $proposalService;
        $this->filterCollectionService = $filterCollectionService;

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
     * @param $intentionsInit
     * @param $intentionsFinish
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function search(User $user = null, array $columns, $search, $intentionsInit = '', $intentionsFinish = '')
    {
        return $this->advertiserService->search($user, $columns, $search, $intentionsInit, $intentionsFinish);
    }

    /**
     * @param User|null $user
     * @param array $columns
     * @param string $search
     * @param string $intentionsInit
     * @param string $intentionsFinish
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchAndFilter(User $user = null, array $columns, $search = '', $intentionsInit = '', $intentionsFinish = '')
    {
        return $this->filterCollectionService->filterAdvertiserCollection($this->search($user, $columns, $search, $intentionsInit, $intentionsFinish), $columns);
    }

    /**
     * @return mixed
     */
    public function searchProposals()
    {
        return $this->proposalService->search();
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

    /**
     * @param Advertiser $advertiser
     * @param $action_date
     * @param $contact_type
     * @param $title
     * @return mixed|null
     */
    public function createQuoteContact(Advertiser $advertiser, $action_date, $contact_type, $title)
    {
        return $this->createSimpleContact($advertiser, env("APP_ACTION_LEAD", 4), $action_date, $contact_type, $title);
    }


    /**
     * @param Advertiser $advertiser
     * @param array $data
     * @param array $questions
     * @param $action_date
     * @param $contact_type
     * @return array
     */
    public function createQuote(Advertiser $advertiser, array $data, array $questions, $action_date, $contact_type)
    {
        if(array_key_exists('0', $questions)) {
            unset($questions[0]);
        }


        $contact = $this->createQuoteContact($advertiser, $action_date, $contact_type, $data['title']);
        $actionAt = $contact->action ? $contact->action->action_at_datetime : $contact->created_at;

        $quote   = $this->advertiserService->createQuote($advertiser, $data + ['sent_at' => $actionAt]);
        $this->advertiserService->updateModel(['comments' => $data['advertiser_comments']], $advertiser);

        $this->quoteService->addQuestions($quote, $questions);
        $this->quoteService->addCities($quote, $data['cities']);
        //$this->quoteService->addAudiences($quote, $data['audiences']);

        $this->proposalService->createModel(['quote_id' => $quote->id, 'title' => $data['title']]);

        return ['contact' => $contact, 'quote' => $quote];
    }

    /**
     * @param Quote $quote
     * @param array $data
     * @param array $questions
     * @return array
     */
    public function updateQuote(Quote $quote, array $data, array $questions)
    {
        if(array_key_exists('0', $questions)) {
            unset($questions[0]);
        }

        $this->quoteService->update($quote, $data, $questions);
        $quote->load(['questions', 'cities']);

        return ['quote' => $quote];
    }
}