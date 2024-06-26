<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>@yield('head_text')</title>
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
                <h1 style='color: #ffffff; margin: 0'>@yield('head_text')</h1>
            </td>
        </tr>
        @yield('content')
        <tr>
            <td bgcolor='#008000' style='padding: 5px 30px'>
                <p style='color: #ffffff; margin: 5px 0; text-align: center'>
                    Connect with us:
                </p>
                                <!-- Social Media Icons -->
                <div style="text-align: center">
                    <a href="http://www.facebook.com/verdroof" style="text-decoration: none; color: #666666; margin: 0 10px;">
                        <img src="https://img.icons8.com/?size=100&id=13912&format=png&color=000000" alt="Facebook"
                            style="width: 24px; height: 24px;">
                    </a>
                    <a href="http://www.twitter.com/verdroof" style="text-decoration: none; color: #666666; margin: 0 10px;">
                        <img src="https://img.icons8.com/?size=100&id=5MQ0gPAYYx7a&format=png&color=000000" alt="Twitter"
                            style="width: 24px; height: 24px;">
                    </a>
                    <a href="http://www.instagram.com/verdroof" style="text-decoration: none; color: #666666; margin: 0 10px;">
                        <img src="https://img.icons8.com/?size=100&id=Xy10Jcu1L2Su&format=png&color=000000" alt="LinkedIn"
                            style="width: 24px; height: 24px;">
                    </a>
                </div>

            </td>
        </tr>
        <tr>
            <td bgcolor='#008000' style='padding: 5px 20px'>
                <p style='color: #ffffff; margin: 5px 0; text-align: center'>
                    Verdroof .18A, Olusegun Aina St, Ikoyi, 101233,
                    Nigeria
                </p>
                <p style='color: #ffffff; margin: 5px 0; text-align: center'>
                    © 2024 Verdroof Labs Limited 2024. All rights reserved
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 20px; text-align: center;">
              <p style="color: #999999; font-size: 12px; line-height: 1.4;">You are receiving this email because you have a verdroof account. If you no longer wish to receive emails from us, <a href="#" style="color: #4CAF50; text-decoration: none;">unsubscribe here</a>.</p>
            </td>
        </tr>
    </table>
</body>

</html>
