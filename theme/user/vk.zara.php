@inject("maksa", "Maksa")
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LocalPay - Панель партнера</title>

        <!-- Vendor CSS -->
        <link href="/assets/vendors/animate-css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/app.min.css" rel="stylesheet">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>

    <body class="login-content">

        <!-- Register -->
        <form class="lc-block toggled" id="l-register" method="POST" action="#">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-account-box"></i></span>
                <div class="col-sm-6">
                    <div class="fg-line">    
                        <input type="text" class="form-control" placeholder="Имя" value="{{ $user['response'][0]['first_name'] }}" disabled>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="fg-line">    
                        <input type="text" class="form-control" placeholder="Фамилия" value="{{ $user['response'][0]['last_name'] }}" disabled>
                    </div>
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-person"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Логин" id="reg-login" value="{{ $user['response'][0]['screen_name'] }}" disabled>
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-mail"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Адрес" name="email">
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Пароль" name="password">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="agreement">
                    <i class="input-helper"></i>
                    Я согласен с <a href="#">пользовательским соглашением</a>
                </label>
            </div>

            <button type="submit" class="btn btn-login btn-danger btn-float waves-circle" name="reg" value="true"><i class="md md-arrow-forward"></i></button>

            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Авторизация</li>
                <li data-block="#l-forget-password" class="bgm-orange">Забыли пароль?</li>
            </ul>
        </form>

        <!-- Javascript Libraries -->
        <script src="/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/assets/js/jquery.form.js"></script> 
        <script src="/assets/js/bootstrap.min.js"></script>

        <script src="/assets/vendors/waves/waves.min.js"></script>
        <script src="/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="/assets/vendors/nicescroll/jquery.nicescroll.min.js"></script>
        <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
        <script src="/assets/js/functions.js"></script>

        <script>
            $('#l-register').ajaxForm({ 
                url: '/auth/vk',
                dataType: 'text',
                success: function(data) {
                    console.log(data);
                    data = $.parseJSON(data);
                    switch(data.status) {
                        case 'error':
                            message(data.error, 'danger');
                            $('button[type=submit]').prop('disabled', false);                                               
                            break;
                        case 'success':
                            message(data.success, 'success');
                            setTimeout (function (){location.href = ('/');}, 100);
                            break;
                    }
                },
                beforeSubmit: function(arr, $form, options) {
                    $('button[type=submit]').prop('disabled', true);
                }
            });
        </script>
    </body>
</html>