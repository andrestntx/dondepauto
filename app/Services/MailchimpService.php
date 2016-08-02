<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 27/04/2016
 * Time: 10:21 AM
 */

namespace App\Services;

use App\Entities\Platform\User;
use Mailchimp\Mailchimp;

class MailchimpService
{
    protected $mailchimp;
    protected $listId   = 'd0d7798032';
    protected $workflow = '3932261c4f';
    protected $groups = [
        'roles' => [
            'publisher'     => '482f385d33',
            'advertiser'    => '1a96a1589a'
        ],
        'type' => [
            'client'    => '786dfd4be5',
            'potential' => 'c56aff9b9d'
        ],
        'activity' => '',
    ];

    protected $automations = [
        'letter' => '52f30620dc'
    ];

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return '/lists/' . $this->listId . '/members';
    }

    /**
     * @param User $user
     * @return string
     */
    public function getUserUrl(User $user)
    {
        return $this->getBaseUrl() . '/' . $user->mailchimp_id;
    }

    /**
     * @param $automation_id
     * @return string
     */
    public function getAutomationUrl($automation_id)
    {
        return 'automations/' . $this->workflow . '/emails/' . $automation_id . '/queue';
    }

    /**
     * Pull the Mailchimp-instance from the IoC-container.
     * @param Mailchimp $mailchimp
     */
    public function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }


    /**
     * Access the mailchimp lists API
     * @param User $user
     * @param array $interests
     */
    protected function syncMember(User $user, array $interests)
    {
        $this->mailchimp->put($this->getUserUrl($user), [
            'email_address' => $user->email,
            //'status'      => 'subscribed',
            "status_if_new" => "subscribed",
            'merge_fields'  =>  [
                'FNAME'     => $user->first_name,
                'LNAME'     => $user->last_name
            ],
            'interests'      => $interests
        ]);
    }

    /**
     * @param User $user
     */
    function syncAdvertiser(User $user)
    {
        $this->syncMember($user,[
            $this->groups['roles']['advertiser'] => true,
            $this->groups['type']['client'] => true
        ]);
    }

    /**
     * @param User $user
     */
    function syncPublisher(User $user)
    {
        $this->syncMember($user,[
            $this->groups['roles']['publisher'] => true,
            $this->groups['type']['client'] => true
        ]);
    }

    /**
     * @param $automationKey
     * @param User $user
     */
    public function putAutomation($automationKey, User $user)
    {
        /*$this->mailchimp->post($this->getAutomationUrl($this->automations[$automationKey]), [
            'email_address' => $user->email
        ]);*/

        \Log::info($this->mailchimp->get("lists/d0d7798032/interest-categories/dcae808f2c/interests"));
    }
}