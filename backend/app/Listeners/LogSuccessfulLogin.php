<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct(public Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        activity()
           ->performedOn($event->user)
           ->causedBy($event->user)
           ->withProperty('ip_address', $this->request->ip())
           ->withProperty('user_agent', $this->request->userAgent())
           ->log('Usuario inició sesión exitosamente');
    }
}
