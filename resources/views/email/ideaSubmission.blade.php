@component('mail::message')
<img src="{{ $header_image }}"><br><br>

Hi, <br><br>

We are pleased to inform you that a new idea has been submitted in {{ $category }} category by one of the staff members of your
department. This email serves as a notification that a new idea has been added to the platform. <br><br>
<div style="display: flex;justify-content: center;align-items: center;flex-direction: column;">
{{ $staff->name }} published a new idea post.
</div>

@component('mail::button', ['url' => $url])
    View Idea
@endcomponent

<hr>
Thanks,<br>
Team {{ config('app.name') }} <br>
This is auto generate email, Please do not reply.
@endcomponent
