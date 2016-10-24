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
use App\Entities\Proposal\Proposal;
use Illuminate\Database\Eloquent\Collection;
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
            $m->from($fromEmail, $fromName)
                ->to($user->email, $user->name)
                ->bcc('andres@dondepauto.co', 'Andrés Pinzón')
                ->subject(ucfirst($user->company) .  ', bienvenido a la agencia DóndePauto');
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
        $this->sendInvitation($advertiser, 'advertiser.confirm', $code);
    }

    /**
     * @param User $publisher
     * @param $letterPath
     * @param $termsPath
     */
    public function sendLetter(User $publisher, $letterPath, $termsPath)
    {
        if(env('APP_ENV') == 'production') {
            Mail::send('emails.publisher.letter', ['publisher' => $publisher], function ($m) use ($publisher, $letterPath) {
                $m->from('alexander@dondepauto.co', 'Alexander Niño de DóndePauto')
                    ->to($publisher->representative->email, $publisher->representative->name)
                    ->bcc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->bcc('alexander@dondepauto.co', 'Alexander Niño')
                    ->subject('Carta de Incentivos DóndePauto')
                    ->attach($letterPath, []);
            });
        }
    }

    /**
     * @param User $publisher
     * @param $comments
     */
    public function changeAgreement(User $publisher, $comments)
    {
        $fromEmail = self::$fromEmail;
        $fromName = self::$fromName;

        if(env('APP_ENV') == 'production') {
            Mail::send('emails.publisher.change-agreement', ['publisher' => $publisher, 'comments' => $comments], function ($m) use ($publisher, $fromEmail, $fromName) {
                $m->from($fromEmail, $fromName)
                    ->to('alexander@dondepauto.co', 'Alexander Niño')
                    ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->subject($publisher->first_name . ' de ' . $publisher->company . ' solicita cambiar datos de acuerdo');
            });
        }
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

        if(env('APP_ENV') == 'production') {
            Mail::send('emails.notifications.change-user-role', ['user' => $user, 'newType' => $newType, 'timestamp' => $timestamp], function ($m) use ($to, $toName, $user, $newType, $fromEmail, $fromName) {
                $m->from($fromEmail, $fromName)
                    ->to($to, $toName)
                    ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->cc("alexander@dondepauto.co", "Alexander Niño")
                    ->subject($user->first_name . ' de ' . $user->company . ' ahora es ' . $newType);
            });
        }
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

        if(env('APP_ENV') == 'production') {
            Mail::send('emails.notifications.new-offer', ['publisher' => $publisher, 'space' => $space], function ($m) use ($fromEmail, $fromName, $publisher) {
                $m->from($fromEmail, $fromName)
                    ->to("leonardo@dondepauto.co", "Leonardo Rueda")
                    ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->cc("alexander@dondepauto.co", "Alexander Niño")
                    ->subject($publisher->company . " acaba de crear una nueva oferta");
            });
        }
    }


    /**
     * @param Space $space
     */
    public function notifyEditOffer(Space $space)
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";
        $publisher = $space->publisher;

        if(env('APP_ENV') == 'production') {
            Mail::send('emails.notifications.edit-offer', ['publisher' => $publisher, 'space' => $space], function ($m) use ($fromEmail, $fromName, $publisher) {
                $m->from($fromEmail, $fromName)
                    ->to("leonardo@dondepauto.co", "Leonardo Rueda")
                    ->cc('alexander@dondepauto.co', 'Alexander Niño')
                    ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->subject($publisher->company . " acaba de editar una oferta");
            });
        }
    }

    /**
     * @param Space $space
     */
    public function notifyInactiveOffer(Space $space, $option)
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";
        $publisher = $space->publisher;

        if(env('APP_ENV') == 'production') {
            if($option == 'incomplete') {
                Mail::send('emails.notifications.inactive-incomplete-offer', ['publisher' => $publisher, 'space' => $space], function ($m) use ($fromEmail, $fromName, $publisher) {
                    $m->from($fromEmail, $fromName)
                        ->cc('alexander@dondepauto.co', 'Alexander Niño')
                        ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                        ->subject("Hemos inactivado una oferta tuya");
                });
            } else if($option == 'terms') {
                Mail::send('emails.notifications.inactive-terms-offer', ['publisher' => $publisher, 'space' => $space], function ($m) use ($fromEmail, $fromName, $publisher) {
                    $m->from($fromEmail, $fromName)
                        ->cc('alexander@dondepauto.co', 'Alexander Niño')
                        ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                        ->subject("Hemos inactivado una oferta tuya");
                });
            }
        }
    }

    /**
     * @param User $publisher
     */
    public function notifyDocuments(User $publisher)
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";

        if(env('APP_ENV') == 'production') {
            Mail::send('emails.notifications.new-documents', ['publisher' => $publisher], function ($m) use ($fromEmail, $fromName, $publisher) {
                $m->from($fromEmail, $fromName)
                    ->cc("alexander@dondepauto.co", "Alexander Niño")
                    ->cc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->subject($publisher->company . " acaba de enviar los documentos societarios");
            });
        }
    }

    /**
     * @param User $user
     */
    public function notifyUserDelete(User $user)
    {
        $fromEmail = self::$fromEmail;
        $fromName = self::$fromName;

        if(env('APP_ENV') == 'production') {
            Mail::send('emails.notifications.delete-user', ['user' => $user], function ($m) use ($fromEmail, $fromName, $user) {
                $m->from($fromEmail, $fromName)
                    ->bcc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->subject($user->first_name . ", hemos dado de baja tu cuenta en DóndePauto");
            });
        }
    }

    /**
     * @param Space $space
     * @param Collection $advertisers
     * @param int $discount
     * @return bool
     */
    public function suggest(Space $space, Collection $advertisers, $discount = 0)
    {
        foreach($advertisers as $advertiser) {
            Mail::send('emails.advertiser.suggest', ['space' => $space, 'advertiser' => $advertiser, 'discount' => $discount], function ($m) use ($advertiser) {
                $m->from("leonardo@dondepauto.co", "Leonardo Rueda")
                    ->to($advertiser->email, ucfirst($advertiser->first_name))
                    ->bcc('andres@dondepauto.co', 'Andrés Pinzón')
                    ->subject(ucfirst($advertiser->first_name) . ", me gusta este medio publicitario para tu empresa");
            });
        }

        return true;
    }

    public function notifyProposalSelected(Proposal $proposal)
    {
        $fromEmail = self::$fromEmail;
        $fromName = "Notificaciones DóndePauto";

        Mail::send('emails.notifications.proposal-selected', [
            'proposal'      => $proposal,
            'advertiser'    => $proposal->getAdvertiser(),
            'spaces'        => $proposal->viewSpaces],
            function ($m) use ($fromEmail, $fromName, $proposal) {
                $m->from($fromEmail, $fromName)
                    ->bcc('andres@dondepauto.co', 'Andrés Pinzón')
                    //->bcc('leonardo@dondepauto.co', 'Leonardo Rueda')
                    ->subject($proposal->getAdvertiser()->company . ", ha seleccionado " . $proposal->viewSpaces->count() . " espacios de la propuesta");
            });
    }

}