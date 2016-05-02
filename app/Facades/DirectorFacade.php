<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 27/04/2016
 * Time: 5:16 PM
 */

namespace App\Facades;

use App\Entities\User;
use App\Services\AdvertiserService;

class DirectorFacade
{
    protected $advertiserService;

    public function __construct(AdvertiserService $advertiserService)
    {
        $this->advertiserService = $advertiserService;
    }

    /**
     * @param array $advertiserIds
     * @param User $user
     * @return mixed
     */
    public function unlinkAdvertisers(array $advertiserIds, User $user)
    {
        return $this->advertiserService->unlinkAdvertisers($advertiserIds, $user);
    }

    /**
     * @param array $advertiserIds
     * @param User $user
     * @return mixed
     */
    public function linkAdvertisers(array $advertiserIds, User $user)
    {
        return $this->advertiserService->linkAdvertisers($advertiserIds, $user);
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function advertisers(User $user)
    {
        return $this->advertiserService->search($user);
    }
}