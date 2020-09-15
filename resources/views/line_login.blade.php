<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
    <title>LINE Web Login</title>
    <style>
        .area {
            background-color: #f5f8fa;
            border: 1px solid #edeeee;
            border-radius: 6px;
            margin: 10px 0;
            padding: 30px 0;
            word-break: break-all;
        }
        .area-margin {
            text-align: center;
            margin: 30px 10px;
        }


        #web-login-button a {
            width: 151px;
            height: 44px;
            background: url("../images/btn_login_base.png") no-repeat;
            display: block;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            max-width: 100%;
        }
        .profile-margin {
            text-align: center;
            margin: 10px;
        }

        .profile-button {
            margin: 20px 0
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="area">
                <h4 class="text-center area-margin">LINE Web Login</h4>
                <div id="web-login-button" class="center-block area-margin">
                    <a class="center-block" href="{{ route('line_login') }}"></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
