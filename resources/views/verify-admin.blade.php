<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style>
        @font-face {
            font-family: 'roboto-regular';

            src: {
                    {
                    url('assets/fonts/Roboto/roboto-regular.ttf')
                }
            }

            ;
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
            <td>
                <br>
                <p style="margin-bottom:0;line-height:21px;">Thanks for started with {{$sitesetting->title}}!. We need a little more information to completer your registration, including conformation of your email address. Click below to conform your email address:
                </p>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <div style="margin-top:20px;">
                    {{-- <a href="{{route('verify-register')}}">{{url('conform-email',['email'=>$user->email,'token'=>$token])}}</a> --}}
                    <a href="{{url('conform-email',['email'=>$user->email])}}"><button type="button" class="btn btn-info">Verify Email Address</button></a>
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