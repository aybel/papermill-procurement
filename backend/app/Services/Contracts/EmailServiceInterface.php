<?php

namespace App\Services\Contracts;

use Illuminate\Mail\Mailable;

interface EmailServiceInterface
{
    /**
     * Envía un correo electrónico usando un Mailable.
     *
     * @param string $to El destinatario del correo.
     * @param Mailable $mailable La clase Mailable que representa el correo.
     * @return void
     */
    public function send(string $to, Mailable $mailable): void;
}
