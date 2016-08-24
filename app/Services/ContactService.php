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
use Carbon\Carbon;

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
        if(array_key_exists('action_at', $action) && ! empty($action['action_at'])) {
            $contact->actions()->attach($action['id'], [
                'action_at' => Carbon::createFromFormat('Y-m-d h:i A', $action['action_at'])->toDateTimeString()
            ]);
        } else {
            $contact->actions()->attach($action['id']);
        }
    }
}