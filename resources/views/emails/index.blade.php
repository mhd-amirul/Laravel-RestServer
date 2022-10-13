<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">

    <style>
        html, body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            background: #f1f1f1;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,

        /* What it does: Fixes webkit padding issue. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
        a {
            text-decoration: none;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .unstyle-auto-detected-links *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* What it does: Prevents Gmail from changing the text color in conversation threads. */
        .im {
            color: inherit !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img + div {
            display: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */

        /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
            u ~ div .email-container {
                min-width: 320px !important;
            }
        }
        /* iPhone 6, 6S, 7, 8, and X */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
            u ~ div .email-container {
                min-width: 375px !important;
            }
        }
        /* iPhone 6+, 7+, and 8+ */
        @media only screen and (min-device-width: 414px) {
            u ~ div .email-container {
                min-width: 414px !important;
            }
        }

    </style>
    <style>
        .bg_white{
            background: #ffffff;
        }

        /*BUTTON*/
        .btn{
            padding: 10px 15px;
            display: inline-block;
        }
        .btn.btn-primary{
            border-radius: 5px;
            background: #30e3ca;
            color: #ffffff;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: 'Lato', sans-serif;
            color: #000000;
            margin-top: 0;
            font-weight: 400;
        }

        body{
            font-family: 'Lato', sans-serif;
            font-weight: 400;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(0,0,0,.4);
        }

        a{
            color: #30e3ca;
        }

        /*LOGO*/

        .logo h1{
            margin: 0;
        }
        .logo h1 a{
            color: #30e3ca;
            font-size: 24px;
            font-weight: 700;
            font-family: 'Lato', sans-serif;
        }

        /*HERO*/
        .hero{
            position: relative;
            z-index: 0;
        }

        .hero .text{
            color: rgba(0,0,0,.3);
        }
        .hero .text h2{
            color: #000;
            font-size: 40px;
            margin-bottom: 0;
            font-weight: 400;
            line-height: 1.4;
        }
        .hero .text h3{
            font-size: 24px;
            font-weight: 300;
        }
        .hero .text h2 span{
            font-weight: 600;
            color: #30e3ca;
        }


    </style>


</head>

<body width="100%" style="margin: 0; padding: 0 !important; background-color: #f1f1f1;">
    <div style="max-width: 600px; margin: 0 auto; margin-top: 2cm;" class="email-container">
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
            <tr>
            <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td class="logo" style="text-align: center;">
                            <h1>Verification Code</h1>
                        </td>
                    </tr>
                </table>
            </td>
            </tr><!-- end tr -->

            <tr>
            <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0;">
                <table>
                    <tr>
                        <td>
                            <div class="text" style="padding: 0 2.5em; text-align: center;">
                                <h2>To complete your RentCar verification, please use the following code :</h2>
                                <h3>{{ $data['otp'] }}</h3>
                                {{-- <p><a href="#" class="btn btn-primary">{{ $otp['nm_link'] }}</a></p> --}}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            </tr><!-- end tr -->
        <!-- 1 Column Text + Button : END -->
        </table>
    </div>
</body>
</html>
