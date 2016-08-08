<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:26 PM
 */

namespace App\Services;


use App\Entities\User;
use App\Entities\Platform\User as UserPlatform;
use App\Repositories\Platform\UserRepository;
use App\Repositories\Views\AdvertiserRepository;

class AdvertiserService extends ResourceService
{
    protected $viewRepository;
    /**
     * UserService constructor.
     * @param UserRepository|AdvertiserRepository $repository
     * @param AdvertiserRepository $viewRepository
     */
    function __construct(UserRepository $repository, AdvertiserRepository $viewRepository)
    {
        $this->repository = $repository;
        $this->viewRepository = $viewRepository;
    }

    /**
     * @param array $advertiserIds
     * @param User $user
     * @return mixed
     */
    public function unlinkAdvertisers(array $advertiserIds, User $user)
    {
        return $this->repository->unlinkAdvertisers($advertiserIds, $user);
    }

    /**
     * @param array $advertiserIds
     * @param User $user
     * @return mixed
     */
    public function linkAdvertisers(array $advertiserIds, User $user)
    {
        return $this->repository->linkAdvertisers($advertiserIds, $user);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function advertisersWithOutAdviser()
    {
        return ['data' => $this->viewRepository->advertisersWithOutAdviser()];
    }


    /**
     * @param User|null $user
     * @param array $columns
     * @param array $search
     * @param null $intentionsInit
     * @param null $intentionsFinish
     * @return mixed
     */
    public function search(User $user = null, array $columns, array $search, $intentionsInit = null, $intentionsFinish = null)
    {   
        return $this->viewRepository->search($user, $columns, $search, $intentionsInit, $intentionsFinish);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $data['role'] = 'advertiser';
        return $this->repository->create($data);
    }

    /**
     * @param UserPlatform $advertiser
     * @param $mailchimpId
     * @return bool
     */
    public function setMailchimpId(UserPlatform &$advertiser, $mailchimpId)
    {
        return $this->repository->setMailchimpId($advertiser, $mailchimpId);
    }

    /**
     * @param UserPlatform $user
     * @return bool
     */
    public function changeRole(UserPlatform $user)
    {
        return $this->repository->changeRole($user, 'publisher');
    }

    /**
     * @param UserPlatform $advertiser
     * @param null $comments
     * @return mixed
     */
    public function createContact(UserPlatform $advertiser, $comments = null)
    {
        return $this->repository->createContact($advertiser, $comments);
    }
}