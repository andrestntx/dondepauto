<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 14/04/2016
 * Time: 5:16 PM
 */

namespace App\Facades;

use App\Entities\Platform\User;
use App\Services\ContactService;
use App\Services\Platform\UserService;

class UserFacade
{
    protected $userPlatformService;
    protected $contactService;

    /**
     * UserFacade constructor.
     * @param UserService $userPlatformService
     * @param ContactService $contactService
     */
    public function __construct(UserService $userPlatformService, ContactService $contactService)
    {
        $this->userPlatformService = $userPlatformService;
        $this->contactService = $contactService;
    }

    /**
     * @param User $user
     * @param array $data
     * @return mixed|null
     */
    public function createContact(User $user, array $data)
    {
        if(array_key_exists('action', $data) && array_key_exists('comments', $data)) {
            $contact = $this->userPlatformService->createContact($user, $data['comments']);

            if( ! empty($data['action']['id'])) {
                $this->contactService->addAction($contact, $data['action']);
            }

            $contact->load('actions');

            return $contact;
        }

        return null;
    }


}