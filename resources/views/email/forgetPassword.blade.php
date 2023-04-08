@component('mail::message')
<img src="{{ $header_image }}"><br><br>

Hi, <br><br>

Make sure we’ve got your email right. Please confirm your e-mail address by clicking on the button below to reset the password.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

<hr>
Thanks,<br>
Team {{ config('app.name') }} <br>
This is auto generate email, Please do not reply.
@endcomponent
