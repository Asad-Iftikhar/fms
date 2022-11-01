@component('mail::message')
    <h2>Hello {{ $data->name }},</h2>
    <p>Its just a reminder message that your collection is pending.</p>
    <p> <b>Title : {{ $data->title }}</b></p>
    <p> <b>Amount : {{ $data->amount }}</b></p>
    <br>
    <br>
    <h4>Thanks,<br> Nextbridge</h4>
@endcomponent
