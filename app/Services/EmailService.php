<?php

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/04/2016
 * Time: 5:14 PM
 */

namespace App\Services;

use App\Entities\Platform\User;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    protected static $fromEmail = 'noresponder@dondepauto.co';
    protected static $fromName = 'Equipo DóndePauto.CO';

    public function sendInvitation(User $user, $view, $code)
    {
        $fromEmail = self::$fromEmail;
        $fromName = self::$fromName;
        
        Mail::send('emails.' . $view, ['user' => $user, 'code' => $code], function ($m) use ($user, $fromEmail, $fromName) {
            $m->from($fromEmail, $fromName);
            $m->to($user->email, $user->name)->subject('Te invitamos a unirte a DondePauto.co');
        });
    }

    public function sendPublisherInvitation(User $publisher, $code)
    {
        $this->sendInvitation($publisher, 'publisher.confirm', $code);
    }

    public function sendAdvertiserInvitation(User $advertiser, $code)
    {
        $this->sendInvitation($advertiser, 'confirm_advertiser', $code);
    }
}