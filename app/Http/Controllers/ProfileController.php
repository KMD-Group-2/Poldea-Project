<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('pages.profile.account',compact('user'));
    }

    public function ChangePassword(ChangePasswordRequest $request)
    {
        $request->ValidCurrentPassword();

        $user = User::find(Auth::user()->id);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('status', 'Successfully change password!');
    }
}
