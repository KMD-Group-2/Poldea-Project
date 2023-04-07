<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCredential extends Mailable
{
    use Queueable, SerializesModels;

    public array $credentials;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name', 'Poldea'). ' Account Credentials')
        ->markdown('email.accountCredential', [
            'url' => route('login'),
            'credentials' => $this->credentials,
        ]);
    }
}
