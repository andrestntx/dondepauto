<?php
/**
 * Created by PhpStorm.
 * Users: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:26 AM
 */

namespace App\Repositories\Platform;


use App\Entities\User;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Platform\User';
    }

    /**
     * @param array $advertiserIds
     * @param User $user
     * @return mixed
     */
    public function unlinkAdvertisers(array $advertiserIds, User $user)
    {
        return $this->model
                ->role('advertiser')
                ->ofUser($user->id)
                ->inIds($advertiserIds)
                ->update(['user_id' => null]);
    }

    /**
     * @param array $advertiserIds
     * @param User $user
     * @return mixed
     */
    public function linkAdvertisers(array $advertiserIds, User $user)
    {
        return $this->model
            ->role('advertiser')
            ->inIds($advertiserIds)
            ->update(['user_id' => $user->id]);
    }
    
    /**
     * @return Collection
     */
    public function advertisersWithOutAdviser()
    {
        return $this->model
            ->role('advertiser')
            ->whereNull('user_id')
            ->select(['id_us_LI as id', 'nombre_us_LI as first_name', 'apellido_us_LI as last_name', 
                'email_us_LI as email', 'empresa_us_LI as company', 'id_us_LI as DT_RowId'])
            ->get();
    }

    /**
     * @param array $data
     * @param $entity
     * @return mixed
     */
    public function update(array $data, $entity)
    {
        if(! array_key_exists('signed_agreement', $data))
        {
            $data['signed_agreement'] = 0;
        }
        
        return parent::update($data, $entity);
    }

    /**
     * @param \App\Entities\Platform\User $advertiser
     * @param $mailchimpId
     * @return bool
     */
    public function setMailchimpId(\App\Entities\Platform\User &$advertiser, $mailchimpId)
    {
        $advertiser->mailchimp_id = $mailchimpId;
        return $advertiser->save();
    }
    
}