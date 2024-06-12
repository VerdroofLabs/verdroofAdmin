<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />
        <title>Verify Your Account</title>
    </head>
    <body
        style='
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        color: #000000;
        '
    >
        <table
            align='center'
            border='0'
            cellpadding='0'
            cellspacing='0'
            width='600'
        >
            <tr>
                <td align='center' bgcolor='#008000' style='padding: 20px 0'>
                    <h1 style='color: #ffffff; margin: 0'>Verify Your Account</h1>
                </td>
            </tr>
            <tr>
                <td bgcolor='#ffffff' style='padding: 40px 30px'>
                    <p style='margin: 0'>Dear {{ $data['user'] }},</p>
                    <p style='margin: 20px 0'>
                        Thank you for registering an account with us.
                    </p>
                    <p style='margin: 20px 0'>
                        Please click the button below to verify your account:
                    </p>
                    <h1 style=' margin:20px 0; font-size:17px'>
                        Verification Code:
                        <span style='color:#008000'>{{ $data['code'] }}</span>
                    </h1>
                    <p style='margin: 20px 0'>
                        <a
                            href='{{ $data['url'] }}'
                            style='
                            background-color: #008000;
                            color: #ffffff;
                            padding: 10px 20px;
                            text-decoration: none;
                            border-radius: 5px;
                            '
                        >
                            Verify Account
                        </a>
                    </p>
                    <p style='margin: 20px 0'>
                        If the button did not work, copy the link: {{ $data['url'] }} to your browser.
                    </p>

                    <p style='margin: 20px 0'>
                        If you did not request this, please ignore this email.
                    </p>
                    <p style='margin: 20px 0'>
                        Best regards,<br />
                        Verdroof Lab
                    </p>
                </td>
            </tr>
            <tr>
                <td bgcolor='#008000' style='padding: 20px 30px'>
                    <p style='color: #ffffff; margin: 0; text-align: center'>
                    © 2024 Verdroof. All rights reserved.
                    </p>
                </td>
            </tr>
        </table>
    </body>
</html>
