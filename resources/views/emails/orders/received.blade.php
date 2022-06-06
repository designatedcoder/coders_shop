@component('mail::message')
# You've just purchased our swag, {{ $order['billing_name'] }}!

## We've attached the invoice to this email.<br>

@component('mail::button', ['url' => route('dashboard')])
View Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
