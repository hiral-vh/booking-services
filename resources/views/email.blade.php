<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style>
        @font-face {
            font-family: 'roboto-regular';
            src: {{url('assets/fonts/Roboto/roboto-regular.ttf')}};
        }
        body {
            font-family: 'roboto-regular';
            font-size: 14px;
        }
    </style>
</head>
<body>
    <table style="max-width: 600px;margin:auto;width:100%;  ">
        <tr>
            <td style="text-align: center;">
                <img src="{{url('assets/images/logo.png')}}" alt="" style="height:100px;">
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-bottom:0;font-weight: bold;margin-top:30px;">Dear {{$user->name}},</p>
            </td>
        </tr>
        <tr>
            <td style="border-bottom:1px solid  #dedede;">
                <p style="">Here are your password reset instructions.</p>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin-bottom:0;line-height:21px;">A request to reset your Admin password has been made. If you did not make this request, simply ignore this email. If you did make this request, please reset your password.
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <div style="margin-top:20px;">
                    <h2>OTP:{{$user->otp}}</h2>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
