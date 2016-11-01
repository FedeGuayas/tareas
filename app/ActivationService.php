<?php
/**
 * Clase con la logica para crear los codigos de activacion y enviar correos
 *
 * Created by PhpStorm.
 * User: halain
 * Date: 26-Sep-16
 * Time: 10:51:45 PM
 */

namespace App;

use Illuminate\Support\Facades\Crypt;
use Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;

class ActivationService
{

    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;//24 hrs para reenviar el email

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    //Metodo para enviar el correo de activacion
    public function sendActivationMail($user,$pass){
        //si el user esta activado o se envio el correo recien no hago nada
        if ($user->activated || !$this->shouldSend($user)) {
            return;
        }
        //sino creo el registro en la tabla de activacion con el token y los datos del user y obtengo el token 
        $token = $this->activationRepo->createActivation($user);

        //link enviado al email del usurio con el token
        $link = route('user.activate', $token);

        //mensaje
//        $message = sprintf('Activate account <a href="%s">%s</a>', $link, $link);
        //cambiando raw por send se puede utilizar una plantilla html para el mail
//        $this->mailer->raw($message, function (Message $m) use ($user) {
//            $m->to($user->email)->subject('Activation mail');
//        });
                

        Mail::send('emails.new_user', ['user' => $user,'link'=>$link, 'passw'=>$pass], function ($message) use ($user){
            $message->from('admin@fedeguayas.com.ec', 'Gestion de Tareas');
            $message->subject('Activación de cuenta');
            $message->to($user->email);
        });

    }

    //Metodo para activar al usuario
    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::find($activation->user_id);

        $user->activated = true;
//        $role=Role::where('name', 'register')->first();
//        $user->attachRole($role);
        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    //Metodo para chequear si el email ha sido enviado recientemente
    private function shouldSend($user){
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }


}