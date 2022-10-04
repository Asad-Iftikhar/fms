@component('mail::message')
    <h2>Hello {{ $user->username }},</h2>
    <p>Kindly press the button to reset password.
        @component('mail::button', ['url' => url('account/reset-password', ($HashedToken))])
            Reset Password
        @endcomponent</p>

    Thanks,
    FMS.
@endcomponent
