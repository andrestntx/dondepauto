<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 21/04/2016
 * Time: 11:50 AM
 */

namespace App\Services;

use App\Entities\Platform\Contact;
use App\Repositories\Platform\ContactRepository;
class ContactService extends ResourceService
{
    function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @param Contact $contact
     * @param $action
     */
    public function addAction(Contact $contact, $action)
    {
        $contact->actions()->attach($action['id'], ['action_at' => $action['action_at']]);
    }

    
}