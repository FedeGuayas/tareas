<?php

namespace App\Listeners;

use App\ActivationService;
use App\Events\UserCreated;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendActivationEmail
{
    public $mailer;
    public $activation;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer, ActivationService $activation)
    {
        $this->mailer=$mailer;
        $this->activation=$activation;
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $this->activation->sendActivationMail($event->user);
    }
}
