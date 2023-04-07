<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentSubmission extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name', 'Poldea'). ' Comment Submission')
        ->markdown('email.commentSubmission', [
            'url' => route('idea.detail',$this->comment->idea_id),
            'staff' => $this->comment->user->staff,
            'comment' => $this->comment,
        ]);
    }
}
