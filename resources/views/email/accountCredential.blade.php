@component('mail::message')
<img src="{{ $header_image }}"><br><br>

# Welcome to POLDEA,<br><br>

Hi, <br><br>

You have successfully registered on POLDEA. Here are your account credentials. <br><br>

Username: "{{ $credentials['username'] }}" <br>
Password: "{{ $credentials['password'] }}" <br><br>

You can also login directly from the button below.

@component('mail::button', ['url' => $url])
Login
@endcomponent

<hr>
Thanks,<br>
Team {{ config('app.name') }} <br>
This is auto generate email, Please do not reply.
@endcomponent
