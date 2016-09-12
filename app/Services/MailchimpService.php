<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 27/04/2016
 * Time: 10:21 AM
 */

namespace App\Services;

use App\Entities\Platform\User;
use Exception;
use Mailchimp\Mailchimp;

class MailchimpService
{
    protected $mailchimp;
    protected $listId   = 'd0d7798032';

    protected $workflows = [
        'complete-data' => [
            'id' => '4468b3f136',
            'emails' => [
                '6eb558fea5'
            ]
        ],
        'create-offers' => [
            'id' => 'afdbbe2e40',
            'emails' => [
                '94cc4340af'
            ]
        ],
        'agreement' => [
            'id' => '74225625fc',
            'emails' => [
                '0fbb79c997'
            ]
        ],
        'documents' => [
            'id' => '3678b8196f',
            'emails' => [
                '39741b4672'
            ]
        ],
        'verify_documents' => [
            'id' => '2e19d2109e',
            'emails' => [
                '7cbaf43443'
            ]
        ]
    ];

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

    /**
     * Pull the Mailchimp-instance from the IoC-container.
     * @param Mailchimp $mailchimp
     */
    public function __construct(Mailchimp $mailchimp)
    {
        $this->mailchimp = $mailchimp;
    }

    /**
     * @param $workflow
     * @return mixed
     */
    public function getWorkflow($workflow)
    {
        return $this->workflows[$workflow];
    }

    /**
     * @param $workflow
     * @param $item
     * @return mixed
     */
    public function getWorkflowItem($workflow, $item)
    {
        return $this->getWorkflow($workflow)[$item];
    }

    /**
     * @param $workflow
     * @return mixed
     */
    public function getWorkflowId($workflow)
    {
        return $this->getWorkflowItem($workflow, 'id');
    }

    /**
     * @param $workflow
     * @return mixed
     */
    public function getWorkflowEmails($workflow)
    {
        return $this->getWorkflowItem($workflow, 'emails');
    }

    /**
     * @param $workflow
     * @param $numberEmail
     * @return mixed
     */
    public function getWorkflowEmail($workflow, $numberEmail = 0)
    {
        return $this->getWorkflowItem($workflow, 'emails')[$numberEmail];
    }

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
     * @param $workflow
     * @param int $numberEmail
     * @return string
     */
    public function getAutomationUrl($workflow, $numberEmail = 0)
    {
        return 'automations/' . $this->getWorkflowId($workflow) . '/emails/' . $this->getWorkflowEmail($workflow, $numberEmail) . '/queue';
    }

    /**
     * @param $workflow
     * @return string
     */
    public function getRemoveUserAutomationUrl($workflow)
    {
        return 'automations/' . $this->getWorkflowId($workflow) . '/removed-subscribers';
    }


    /**
     * Access the mailchimp lists API
     * @param User $user
     * @param array $interests
     */
    protected function syncMember(User $user, array $interests)
    {
        if(env('APP_ENV') == 'production') {
            $this->mailchimp->put($this->getUserUrl($user), [
                'email_address' => $user->email,
                //'status'      => 'subscribed',
                "status_if_new" => "subscribed",
                'merge_fields' => [
                    'FNAME' => $user->first_name,
                    'LNAME' => $user->last_name
                ],
                'interests' => $interests
            ]);
        }
    }

    /**
     * @param User $user
     */
    function syncUser(User $user)
    {
        if($user->isPublisher()) {
            $this->syncPublisher($user);
        }
        else {
            $this->syncAdvertiser($user);
        }
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
     * @param User $user
     */
    public function updateRoleUser(User $user)
    {
        if(env('APP_ENV') == 'production') {
            if ($user->isPublisher()) {
                $this->syncPublisher($user);
                $this->syncAutomationPublisher($user);
            } else {
                $this->syncAdvertiser($user);
                $this->stopActualAutomation($user);
            }
        }
    }

    /**
     * @param User $user
     */
    public function syncAutomationPublisher(User $user)
    {
        if(env('APP_ENV') == 'production') {
            if ($user->complete_data && !$user->has_offers) {
                $this->removeUserAutomation('complete-data', $user);
                $this->addUserAutomation('create-offers', $user);
            } else if (!$user->complete_data) {
                $this->addUserAutomation('complete-data', $user);
            }
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function deleteUser()
    {
        try {
            return $this->mailchimp->delete($this->getUserUrl($user));
        } catch (Exception $e) {
            \Log::info('Mailchimp error');
            \Log::info($e);
        }
    }

    /**
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public function removeUser(User $user)
    {
        if(env('APP_ENV') == 'production') {
            $this->stopActualAutomation($user);
            $this->deleteUser();
        }

        return null;
    }

    /**
     * @param User $user
     */
    public function stopActualAutomation(User $user)
    {
        if(env('APP_ENV') == 'production') {
            if ($user->complete_data && $user->has_offers) {
                $this->removeUserAutomation('create-offers', $user);
            } else {
                $this->removeUserAutomation('complete-data', $user);
            }
        }
    }

    /**
     * @param $workflow
     * @param User $user
     * @param int $numberEmail
     */
    public function addUserAutomation($workflow, User $user, $numberEmail = 0)
    {
        if(env('APP_ENV') == 'production') {
            try {
                $this->mailchimp->post($this->getAutomationUrl($workflow, $numberEmail), [
                    'email_address' => $user->email
                ]);
            } catch (Exception $e) {
                \Log::info('Mailchimp error');
                \Log::info($e);
            }
        }
    }

    /**
     * @param $workflow
     * @param User $user
     */
    public function removeUserAutomation($workflow, User $user)
    {
        if(env('APP_ENV') == 'production') {
            try {
                $this->mailchimp->post($this->getRemoveUserAutomationUrl($workflow), [
                    'email_address' => $user->email
                ]);
            } catch (Exception $e) {
                \Log::info('Mailchimp error');
                \Log::info($e);
            }
        }
    }
}