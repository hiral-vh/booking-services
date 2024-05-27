<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="{{ asset($sitesetting->favicon) }}">

    <link href="{{ asset('business/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('business/css/style.css') }}" rel="stylesheet" type="text/css">
    

    <style>
        .field-icon {
        float: right;
        margin-left: -25px;
        margin-top: -25px;
        position: relative;
        z-index: 2;
    }
    header .col2 {
    text-align: center;
}
.logo img {
    height: 60px;
}
footer {
    background: #000;
    padding: 60px 0 30px;
}
.reserved {
    color: #FFFFFF80;
    font-size: 12px;
    margin-top: 20px;
}
.sa-txt {
    color: #FFFFFF80;
    font-size: 12px;
    margin-top: 20px;
    text-align: center;
}
.disclaimer {
    color: #FFFFFF66;
    font-size: 12px;
    text-align: center;
    margin-top: 60px;
    margin-bottom: 0;
}
    </style>
</head>
<body>
    <div id="wrapper">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col2">
                        <a href="index.html" class="logo"><img src="{{asset('chimpare-logo-dark.svg')}}" alt="logo"> </a>
                    </div>
                </div>
            </div>               
        </header>
        <div name="termly-embed" data-id="1dbf26a2-3115-4458-b631-dcecdadefa5b" data-type="iframe"></div>
    </div>
</body>



<script type="text/javascript">(function(d, s, id) {
var js, tjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "https://app.termly.io/embed-policy.min.js";
tjs.parentNode.insertBefore(js, tjs);
}(document, 'script', 'termly-jssdk'));</script>

</html>