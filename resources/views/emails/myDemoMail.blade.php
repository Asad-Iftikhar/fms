@component('mail::message')
    <h2>Hello {{ $user->first_name }},</h2>
    <p>The email is a sample email for Laravel Tutorial: How to Send an Email using Laravel 8 from @component('mail::button', ['url' =>url('account/forgot-password', array($user->reset_token))])
            Reset Password
        @endcomponent</p>

    <p>Visit @component('mail::button', ['url' => url('account/forgot-password', array($user->reset_token))])
            Laravel Tutorials
        @endcomponent and learn more about the Laravel framework.</p>


    Happy coding!<br>

    Thanks,<br>
    {{ config('app.name') }}<br>
    Laravel Team.
@endcomponent
