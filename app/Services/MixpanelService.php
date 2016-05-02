<?php
/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 26/04/2016
 * Time: 10:12 AM
 */

namespace App\Services;

use App\Entities\Platform\User;
use GeneaLabs\LaravelMixpanel\LaravelMixpanel;

class MixpanelService
{
    protected $mixPanel;

    public function __construct(LaravelMixpanel $mixPanel)
    {
        $this->mixPanel = $mixPanel;
    }

    public function registerUser(User $user)
    {
        $this->mixPanel->people->set($user->id, [
            '$first_name'                        => $user->first_name,
            '$last_name'                         => $user->last_name,
            '$created'                           => $user->created_at,
            '$email'                             => $user->email,
            'DP - User type'                    => $user->tipo_us_LI,
            "DP - User id"                      => $user->id,
			"DP - Email verified"               => 'No',
			"DP - User status"                  => "pendAceptarInvitacion",
			"DP - User suscription plan"        => "1",
			"DP - User suscription plan deadline" => "0000-00-00"
        ]);
    }

    protected function updateUser(User $user, array $data)
    {
        $this->mixPanel->people->set($user->id, $data);
    }

    public function updateAdvertiser(User $advertiser)
    {
        $this->updateUser($advertiser, [
            '$first_name'                        => $advertiser->first_name,
            '$last_name'                         => $advertiser->last_name,
            '$email'                             => $advertiser->email,
            '$created'                           => $advertiser->created_at_mixpanel,
            'DP - Company name'					=> $advertiser->company,
            'DP - Company city'					=> $advertiser->city_name,
            'DP - Company economic activity'	=> $advertiser->activity_name,
            'DP - Company NIT'					=> $advertiser->company_nit,
            'DP - Company address'				=> $advertiser->address,
            'DP - User position area'			=> $advertiser->company_area,
            'DP - User position'				=> $advertiser->company_role,
            'DP - User cellphone'				=> $advertiser->cel,
            'DP - User phone'					=> $advertiser->phone
        ]);
    }

    public function updateMedium(User $medium)
    {
        $this->updateUser($medium, [
            '$first_name'                       => $medium->first_name,
            '$last_name'                        => $medium->last_name,
            '$email'                            => $medium->email,
            '$created'                          => $medium->created_at_mixpanel,
            'DP - Company name'					=> $medium->company,
            'DP - Company city'					=> $medium->city_name,
            'DP - Company NIT'					=> $medium->company_nit,
            'DP - Company address'				=> $medium->address,
            'DP - User position area'			=> $medium->company_area,
            'DP - User position'				=> $medium->company_role,
            'DP - User cellphone'				=> $medium->cel,
            'DP - User phone'					=> $medium->phone,
            'PD - User agreement'               => $medium->signed_agreement_lang
        ]);
    }
}

