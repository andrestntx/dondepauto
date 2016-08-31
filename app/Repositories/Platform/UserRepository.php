<?php
/**
 * Created by PhpStorm.
 * Users: Desarrollador 1
 * Date: 13/04/2016
 * Time: 10:26 AM
 */

namespace App\Repositories\Platform;


use App\Entities\User;
use App\Entities\Platform\User as UserPlatform;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
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

    public function getSpaces(\App\Entities\Platform\User $publisher)
    {
        return $publisher->spaces()
            ->with(['images', 'format.subCategory.category'])
            ->orderBy('nombre_espacio_LI')
            ->paginate(12);
    }

    public function register(array $data)
    {
        return $this->create($data);
    }

    /**
     * @param int $differenceDays
     * @return mixed
     */
    public function getPublisherInComplete($differenceDays = 3)
    {
        return $this->model->with('confirmation')
            ->complete(false)
            ->role('publisher')
            ->get()
            ->filter(function ($publisher, $key) use($differenceDays) {
                return $publisher->email_validated && Carbon::now()->diffInDays($publisher->activated_at) == $differenceDays;
            })->count();
    }

    /**
     * @param int $differenceDays
     * @return mixed
     */
    public function getPublisherNotOffers($differenceDays = 3)
    {
        return $this->model->with('spaces')
            ->complete(true)
            ->role('publisher')
            ->get()
            ->filter(function ($publisher, $key) use($differenceDays) {
                return ! $publisher->has_offers && Carbon::now()->diffInDays($publisher->completed_at) == $differenceDays;
            })->count();
    }

    /**
     * @param int $differenceDays
     * @return mixed
     */
    public function getPublisherHasOffers($differenceDays = 3)
    {
        return $this->model->with('spaces')
            ->complete(true)
            ->role('publisher')
            ->get()
            ->filter(function ($publisher, $key) use($differenceDays) {
                return $publisher->has_offers && Carbon::now()->diffInDays($publisher->last_offert_created_at) == $differenceDays;
            })->count();
    }


    /**
     * @param int $differenceDays
     * @return mixed
     */
    public function getPublisherNotSigned($differenceDays = 3)
    {
        return $this->model->with('spaces')
            ->complete(true)
            ->hasSigned(false)
            ->role('publisher')
            ->get()
            ->filter(function ($publisher, $key) use($differenceDays) {
                return Carbon::now()->diffInDays($publisher->completed_at) == $differenceDays;
            })->count();
    }

    /**
     * @param UserPlatform $user
     * @return bool
     */
    public function changeRole(UserPlatform $user, $role)
    {
        $user->role = $role;
        return $user->save();
    }

    /**
     * @param UserPlatform $user
     * @param null $comments
     * @return mixed
     */
    public function createContact(UserPlatform $user, $comments = null)
    {
        return $user->contacts()->create(['comments' => $comments]);
    }

    /**
     * @param UserPlatform $publisher
     * @param $agreement
     * @return bool
     */
    public function setAgreement(UserPlatform $publisher, $agreement)
    {
        $publisher->signed_agreement = $agreement;
        return $publisher->save();
    }


    /**
     * @param UserPlatform $user
     * @return int
     */
    public function trackLogin(UserPlatform $user)
    {
        $code = rand(1,9000000000000);

        $user->logs()->create([
            'code_log_LI' => $code,
            'fecha_login_LI' => Carbon::now()->toDateTimeString(),
            'sesion_abandonada_LI' => true
        ]);

        return $code;
    }

    /**
     * @param UserPlatform $user
     * @param $code
     */
    public function trackLogout(UserPlatform $user, $code)
    {
        \Log::info('logout');
        $log = $user->logs()->where('code_log_LI', $code)->first();

        if($log) {
            $log->logout_at = Carbon::now()->toDateTimeString();
            $log->abandoned = false;
            $log->save();
        }
    }
}