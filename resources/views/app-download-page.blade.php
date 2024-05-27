
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="" name="description" />
  <meta content="" name="author" />
  <!-- App favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/'. $sitesetting->favicon) }}">

  <!-- Bootstrap Css -->
  <link href="{{asset('business/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
  <style>
    .cke_resizer_ltr {
      display: none;
    }
    .text-container {
    /* background-image: linear-gradient(88deg, #808080, #f0555e); */
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background: transparent linear-gradient( 139deg, #0c0c0c 0%, #3b3b44 27%, #cec9d5 51%, #68646a 72%, #635e64 89%, #000000 100%) 0% 0% no-repeat padding-box;
}

  /*.text-container .d {
	filter: brightness(999);
}*/

  .text-container .btndiv {
    margin-top: 50px;
    text-align: center;
  }

  .text-container .btndiv a {
    display: inline-block;
    padding: 10px 25px;
    background: #fff;
    font-size: 18px;
    margin: 0 10px;
    border-radius: 30px;
    min-width: 280px;
    text-align: center;
    box-shadow: 0 0 0 5px #ffffff6b;
    color: #1C2347;
    transition: 0.2s;
  }

  .text-container .btndiv a:hover {
    box-shadow: 0 0 0 10px #ffffff6b;
    transition: 0.2s;
  }

  @media (max-width: 767px) {
    .text-container .btndiv a {
      margin: 15px 0;
    }

    .text-container .btndiv {
      max-width: 500px;
    }

    .d {
      /*background: #ffffff6b;*/
    }
  }
  </style>

  </head>

<body>
    <div class="text-container">
        <img class="d" width="200px" src="{{ asset('assets/images/'. $sitesetting->logo) }}" style="
        border-radius: 6px;
        padding: 5px;" alt="logo">
        <div class="btndiv">
            <a href="{{$sitesetting->apk_link}}" target="_blank">Download Android APK</a>
            <a href="{{$sitesetting->ipa_link}}" target="_blank">Download IOS IPA</a>
        </div>
      </div>
</body>
</html>
