@component('mail::message')
    <h2>Hello {{ $data->name }},</h2>
    <p>You are Invited to an event organized by NextBridge.</p>
    <p> <b>Event Name : {{ $data->event_name }}</b></p>
    <p> <b>Event Description : {{ $data->desc }}</b></p>
    <p> <b>Event Date : {{ $data->date }}</b></p>
    <br>
    <br>
    <h4>Thanks,<br> Nextbridge</h4>
@endcomponent
