<x-mail::message>
# Email Verification

Thank you for registering. Please use the following 6-digit code to verify your email address:

<x-mail::panel>
**{{ $code }}**
</x-mail::panel>

This code will expire in 60 minutes.

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
