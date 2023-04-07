<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendResetPassword;
use App\Models\User;
use Illuminate\Http\Request;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $query = User::where('username',$request->username)->with('staff')->first();
        if($query)
        {
            if(str_replace(' ', '',$query->staff->email) == str_replace(' ', '',$request->email))
            {
                // send password reset link with SendResetPassword Job
                SendResetPassword::dispatch(
                    $request->only(['email','username'])
                );

                return redirect()->back()->with('status', __('passwords.sent'));
            }else{
                return back()->withInput($request->only('email'))->withErrors(['email' => __('passwords.user')]);
            }
        }else{
            return back()->withInput($request->only('email'))->withErrors(['email' => __('passwords.user')]);
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // return $status == Password::RESET_LINK_SENT
        //             ? back()->with('status', __($status))
        //             : back()->withInput($request->only('email'))
        //                     ->withErrors(['email' => __($status)]);
    }
}
