<?php

namespace App\Jobs;

use App\Mail\PasswordResetLink;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SendResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $credentials;
    private $callback;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $credentials, $callback = null)
    {
        $this->credentials = $credentials;
        $this->callback = $callback;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'username' => $this->credentials['username'],
            'email' => $this->credentials['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::to($this->credentials['email'])->send(new PasswordResetLink($token));

        Log::info('Send Password Reset Link Successfully for '. $this->credentials['email'] .'!');
    }
}
