@component('mail::message')
<img src="{{ $header_image }}"><br><br>

Hi, <br><br>

We are writing to inform you that a new comment has been submitted by {{ $staff->name }} on your idea in the platform. This email serves as a notification that your idea has received a comment.
<div style="display: flex;justify-content: start;align-items: center;flex-direction: row;">
<img src="{{ $staff->photo }}" alt="User Image" style="border-radius: 50%; width:40px;"/>{{$staff->name}}
</div>
{{ $comment->comment }}

@component('mail::button', ['url' => $url])
    View Comment
@endcomponent

<hr>
Thanks,<br>
Team {{ config('app.name') }} <br>
This is auto generate email, Please do not reply.
@endcomponent
