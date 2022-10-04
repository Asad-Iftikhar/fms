@component('mail::message')
    <h2>Hello {{ $user->username }},</h2>
    <p>Email sent, kindly check your inbox.
        @component('mail::button', ['url' => url('account/reset-password', ($HashedToken))])
            Reset Password
        @endcomponent</p>

    Thanks,
    FMS.
@endcomponent
