@component('mail::message')
<img src="data:image/png;base64,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"><br><br>

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
