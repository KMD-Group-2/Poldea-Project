<?php

namespace App\Jobs;

use App\Mail\IdeaSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendIdeaSubmittedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $emails;
    public $idea;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $emails,$idea)
    {
        $this->emails = $emails;
        $this->idea = $idea;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->emails as $email) {
            Mail::to($email)->send(new IdeaSubmission($this->idea));
        }
    }
}
