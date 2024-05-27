<!DOCTYPE html>
<html>
<head>
    <title></title>
        <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{url('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{url('assets/css/style.css')}}" rel="stylesheet" type="text/css">

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
            <td>
                <br>
                <p style="margin-bottom:0;line-height:21px;">Thanks for started with {{$sitesetting->title}}!. We need a little more information to completer your registration, including conformation of your email address. Click below to confirm your email address:
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <div style="margin-top:20px;">
                    <a href="{{url('conform-email',['email'=>$user->email])}}"><button style="border-radius: 2px;padding: 6px 14px;font-size: 14px;color: #ffffff !important;   background-color: #fd8442 !important;border: 1px solid #fd8442 !important;" type="button" class="btn btn-primary">Verify Now</button></a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <p style="margin-bottom:0;line-height:21px;">If you have problems, please paste the above URL into your browser.
                </p>
                <br><br>
                Thanks,
                <br>
                {{$sitesetting->title}} Support
            </td>
        </tr>
    </table>
</body>
</html>
