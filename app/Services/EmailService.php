<?php

/**
 * Created by PhpStorm.
 * User: Desarrollador 1
 * Date: 25/04/2016
 * Time: 5:14 PM
 */

namespace App\Services;

use App\Entities\Platform\Space\Space;
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

    /**
     * @param User $publisher
     * @param $code
     */
    public function sendPublisherInvitation(User $publisher, $code)
    {
        $this->sendInvitation($publisher, 'publisher.confirm', $code);
    }

    /**
     * @param User $advertiser
     * @param $code
     */
    public function sendAdvertiserInvitation(User $advertiser, $code)
    {
        $this->sendInvitation($advertiser, 'confirm_advertiser', $code);
    }

    /**
     * @param User $publisher
     * @param $letterPath
     * @param $termsPath
     */
    public function sendLetter(User $publisher, $letterPath, $termsPath)
    {
        Mail::send('emails.publisher.letter', ['publisher' => $publisher], function ($m) use ($publisher, $letterPath) {
            $m->from('alexander@dondepauto.co', 'Alexander Niño de DóndePauto')
                ->to($publisher->representative->email, $publisher->representative->name)
                ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                ->cc('nelson@dondepauto.co', 'Nelson Hernandez')
                ->cc('alexander@dondepauto.co', 'Alexander Niño')
                ->subject('Carta de Incentivos DóndePauto')
                ->attach($letterPath, []);
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
                ->to('alexander@dondepauto.co', 'Alexander Niño')
                ->cc('nelson@dondepauto.co', 'Nelson Hernandez')
                ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                ->subject($publisher->first_name . ' de ' . $publisher->company. ' solicita cambiar datos de acuerdo');
        });
    }


    /**
     * @param User $user
     * @param string $newType
     * @param string $to
     * @param string $toName
     */
    public function notifyChangeRole(User $user, $newType = 'Anunciante', $to = "leonardo@dondepauto.co", $toName = "Leonardo Rueda")
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";
        $timestamp = \Carbon\Carbon::now()->toDateTimeString();


        Mail::send('emails.notifications.change-user-role', ['user' => $user, 'newType' => $newType, 'timestamp' => $timestamp], function ($m) use ($to, $toName, $user, $newType, $fromEmail, $fromName) {
            $m->from($fromEmail, $fromName)
                ->to($to, $toName)
                ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                ->subject($user->first_name . ' de ' . $user->company . ' ahora es ' . $newType);
        });
    }

    /**
     * @param User $advertiser
     */
    public function notifyChangeAdvertiserRole(User $advertiser)
    {
        $this->notifyChangeRole($advertiser, 'Anunciante', "leonardo@dondepauto.co", "Leonardo Rueda");
    }

    /**
     * @param User $publisher
     */
    public function notifyChangePublisherRole(User $publisher)
    {
        $this->notifyChangeRole($publisher, 'Medio Publicitario', "nelson@dondepauto.co", "Nelson Hernandez");
    }

    /**
     * @param User $publisher
     * @param Space $space
     */
    public function notifyNewOffer(User $publisher, Space $space)
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";

        Mail::send('emails.notifications.new-offer', ['publisher' => $publisher, 'space' => $space], function ($m) use ($fromEmail, $fromName, $publisher) {
            $m->from($fromEmail, $fromName)
                ->to("leonardo@dondepauto.c", "Leonardo Rueda")
                ->cc('nelson@dondepauto.co', 'Nelson Hernandez')
                ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                ->subject($publisher->company . " acaba de crear una nueva oferta");
        });
    }

    /**
     * @param User $publisher
     */
    public function notifyDocuments(User $publisher)
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";

        Mail::send('emails.notifications.new-documents', ['publisher' => $publisher], function ($m) use ($fromEmail, $fromName, $publisher) {
            $m->from($fromEmail, $fromName)
                ->to("nelson@dondepauto.co", "Nelson Hernandez")
                ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                ->subject($publisher->company . " acaba de enviar los documentos societarios");
        });
    }

}