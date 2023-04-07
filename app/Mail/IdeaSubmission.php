<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IdeaSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $idea;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($idea)
    {
        $this->idea = $idea;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name', 'Poldea'). ' Idea Submission')
        ->markdown('email.ideaSubmission', [
            'staff' => $this->idea->user->staff,
            'category' => $this->idea->category->name,
            'url' => route('idea.detail',$this->idea->id),
        ]);
    }
}
