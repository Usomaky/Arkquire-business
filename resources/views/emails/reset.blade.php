<x-mail::message>
<p>Hello there,</p>

Here's your OTP:

<x-mail::panel>
    <h1>{{$otp}}</h1>
</x-mail::panel>

<p><small>This code expires in {{env('OTP_EXPIRES_AFTER')}} minutes and should not be shared with anybody.</small></p>

<small>For further assistance, contact us at <a href="mailto:info@arkquire.com">info@arkquire.com</a></small>

Thanks,<br>
{{ config('app.name') }} Team
</x-mail::message>
