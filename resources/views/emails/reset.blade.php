<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>Reset Password</title>
</head>
<body
    style='
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #000000;
        '>
    <table align='center' border='0' cellpadding='0' cellspacing='0' width='600'>
        <tr>
            <td align='center' bgcolor='#008000' style='padding: 20px 0'>
                <h1 style='color: #ffffff; margin: 0'>Reset Password</h1>
            </td>
        </tr>
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
        <tr>
            <td bgcolor='#008000' style='padding: 20px 30px'>

               <p style='color: #ffffff; margin: 5px 0; text-align: center'>
                    Connect with us on twitter, facebook, linkedin, instagram - @verdroof
                </p>
                <p style='color: #ffffff; margin: 5px 0; text-align: center'>
                    Verdroof .18A, Olusegun Aina St, Ikoyi, 101233,
                    Nigeria
                </p>
                <p style='color: #ffffff; margin: 5px 0; text-align: center'>
                    © 2024 Verdroof Labs Limited 2024. All rights reserved
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
