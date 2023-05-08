<x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="'http://localhost:3000/reset-password?token=' . $token">
    Reset Password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
