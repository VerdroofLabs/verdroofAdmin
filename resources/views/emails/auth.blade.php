@extends('emails.layout')

@section('head_text', 'Verify Your Account');

@section('content')

<tr>
    <td bgcolor='#ffffff' style='padding: 40px 30px'>
        <p style='margin: 0'>Dear {{ $data['user'] }},</p>
        <p style='margin: 20px 0'>
            Thank you for choosing Verdroof!
        </p>
        <p style='margin: 20px 0'>
            You are almost there.
        </p>
        <p style='margin: 20px 0'>
            Please click the link below to verify your account.
        </p>
        {{-- <h1 style=' margin:20px 0; font-size:17px'>
                Verification Code:
                <span style='color:#008000'>{{ $data['code'] }}</span>
            </h1> --}}
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
        <p style='margin: 20px 0'>
            If the button did not work, copy the link: {{ $data['url'] }} to your browser.
        </p>

        <p style='margin: 20px 0'>
            If you did not request to sign up for a Verdroof account, please ignore this email.
        </p>
        <p style='margin: 20px 0'>
            Regards, <br />
            The Verdroof Team
        </p>
    </td>
</tr>

@endsection
