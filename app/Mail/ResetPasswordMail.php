<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
// Avoid PHP 8 named-argument syntax for compatibility
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $token;

    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Reset Password - CRUD Laravel')
                    ->view('emails.reset-password')
                    ->with([
                        'email' => $this->email,
                        'resetUrl' => route('password.reset.show', $this->token),
                    ]);
    }
}
