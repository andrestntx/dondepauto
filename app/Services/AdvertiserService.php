<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 18/04/2016
 * Time: 2:26 PM
 */

namespace App\Services;


use App\Entities\Proposal\Quote;
use App\Entities\User;
use App\Entities\Platform\User as UserPlatform;
use App\Repositories\Platform\UserRepository;
use App\Repositories\Views\AdvertiserRepository;
use Illuminate\Database\Eloquent\Collection;

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
     * @param $search
     * @param $intentionsInit
     * @param $intentionsFinish
     * @return Collection
     */
    public function search(User $user = null, array $columns, $search = '', $intentionsInit = '', $intentionsFinish = '')
    {   
        return $this->viewRepository->search($user, $columns, $search, $intentionsInit, $intentionsFinish);
    }

    protected function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createModel(array $data)
    {
        $data['role']   = 'advertiser';
        $data['source'] = 'CRM Interno';

        if(! array_key_exists('password', $data)) {
            $data['password'] = $this->generateRandomString();
        }

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
     * @return mixed
     */
    public function getAdvertiserView(UserPlatform $advertiser)
    {
        return $this->viewRepository->getAdvertiser($advertiser->id);
    }

    /**
     * @param UserPlatform $advertiser
     * @param array $data
     * @return Quote
     */
    public function createQuote(UserPlatform $advertiser, array $data)
    {
        return $advertiser->quotes()->create($data);
    }
}