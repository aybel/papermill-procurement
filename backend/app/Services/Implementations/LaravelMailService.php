<?php

namespace App\Services\Implementations;

use App\Services\Contracts\EmailServiceInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class LaravelMailService implements EmailServiceInterface
{
    public function send(string $to, Mailable $mailable): void
    {
        Mail::to($to)->send($mailable);
    }
}
