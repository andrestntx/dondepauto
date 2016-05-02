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
    protected $listId = '2139024e4d';
    protected $groups = [
        'roles' => [
            'medium'        => 'eae14fa74e',
            'advertiser'    => '29b615296a'
        ],
        'type' => [
            'client'    => 'f144fefcda',
            'potential' => '924cd3820e'
        ],
        'activity' => '',
    ];

    public function getBaseUrl()
    {
        return '/lists/' . $this->listId . '/members';
    }

    public function getUserUrl(User $user)
    {
            return $this->getBaseUrl() . '/' . $user->mailchimp_id;
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
            //'status'        => 'subscribed',
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
    function syncMedium(User $user)
    {
        $this->syncMember($user,[
            $this->groups['roles']['medium'] => true,
            $this->groups['type']['client'] => true
        ]);
    }
}