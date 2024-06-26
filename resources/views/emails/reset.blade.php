@extends('emails.layout')

@section('head_text', 'Reset Password');

@section('content')
<tr>
    <td bgcolor='#ffffff' style='padding: 40px 30px'>
        <p style='margin: 0'>Dear Verdroof User,</p>
        <p style='margin: 20px 0'>
            You are receiving this email because we received a password reset request for your account.
        </p>
        <p style='margin: 20px 0'>
            Please click the link below to reset your password.
        </p>

        <p style='margin: 20px 0'>
            <a href='{{ $data['url'] }}'
                style='
                    background-color: #008000;
                    color: #ffffff;
                    padding: 10px 20px;
                    text-decoration: none;
                    border-radius: 5px;
                    '>
                Verify Account
            </a>
        </p>

        <p style='margin: 20px 0'>This password reset link will expire in 60 minutes.</p>

        <p style='margin: 20px 0'>
            If you did not request a password reset, no further action is required..
        </p>
        <p style='margin: 20px 0'>
            Regards, <br />
            The Verdroof Team
        </p>

        <hr>

        <p style='margin: 20px 0'>
            If the button did not work, copy the link: {{ $data['url'] }} to your browser.
        </p>
    </td>
</tr>
@endsection
