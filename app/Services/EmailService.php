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

    public function sendLetter(User $publisher, $letterPath, $termsPath)
    {
        $fromEmail = self::$fromEmail;
        $fromName = self::$fromName;

        Mail::send('emails.publisher.letter', ['publisher' => $publisher], function ($m) use ($publisher, $fromEmail, $fromName, $letterPath, $termsPath) {
            $m->from($fromEmail, $fromName)
                ->to($publisher->email, $publisher->name)
                ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                ->subject('Aquí va la carta de DondePauto.co')
                ->attach($letterPath, [])
                ->attach($termsPath, []);
        });
    }

    /**
     * @param User $publisher
     * @param $comments
     */
    public function changeAgreement(User $publisher, $comments)
    {
        $fromEmail = self::$fromEmail;
        $fromName = self::$fromName;

        Mail::send('emails.publisher.change-agreement', ['publisher' => $publisher, 'comments' => $comments], function ($m) use ($publisher, $fromEmail, $fromName) {
            $m->from($fromEmail, $fromName)
                ->to('alexander@dondepauto.co', 'Alexander')
                ->cc('nelson@dondepauto.co', 'Nelson')
                ->cc('andres@dondepauto.co', 'Andrés')
                ->subject($publisher->first_name . ' de ' . $publisher->company. ' solicita cambiar datos de acuerdo');
        });
    }

}