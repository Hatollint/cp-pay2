@inject("maksa", "Maksa")
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LoalPay - Панель партнера</title>

        <!-- Vendor CSS -->
        <link href="/assets/vendors/animate-css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/app.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    </head>

    <body class="login-content">

        <form class="lc-block" id="l-login" method="POST" action="#">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-person"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" name="login" placeholder="Логин" id="input-login">
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" name="password" placeholder="Пароль">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember">
                    <i class="input-helper"></i>
                    Запомнить меня
                </label>
            </div>

            <a href="#" class="btn btn-vk btn-info btn-float"><i class="fa fa-vk"></i></a>
            <button type="submit" class="btn btn-login btn-danger btn-float waves-circle" name="auth" value="true"><i class="md md-arrow-forward"></i></button>

            <ul class="login-navigation">
                <li data-block="#l-register" class="bgm-red">Регистрация</li>
                <li data-block="#l-forget-password" class="bgm-orange">Забыл пароль?</li>
            </ul>
        </form>

        <!-- Register -->
        <form class="lc-block" id="l-register" method="POST" action="#">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-account-box"></i></span>
                <div class="col-sm-6">
                    <div class="fg-line">    
                        <input type="text" class="form-control" placeholder="Имя" name="firstname">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="fg-line">    
                        <input type="text" class="form-control" placeholder="Фамилия" name="lastname">
                    </div>
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-person"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Логин" name="login" id="reg-login">
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
        @if(empty($error))
        <form class="lc-block toggled" id="l-forget-password" method="POST" action="#">
            <p class="text-left">Введите новый пароль.</p>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Новый пароль" name="newpassword">
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Повторите пароль" name="newpasswordsecond">
                </div>
            </div>

            <button type="submit" class="btn btn-login btn-danger btn-float waves-circle" name="confirm" value="true"><i class="md md-arrow-forward"></i></button>

            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green">Авторизация</li>
                <li data-block="#l-register" class="bgm-red">Регистрация</li>
            </ul>
        </form>
        @else
        <form class="lc-block toggled" id="l-forget-password" method="POST" action="#">
            <div class="alert alert-danger">Данная ссылка восстановления пароля недействительна!</div>
        </form>
        @endif

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
            $('#l-login').ajaxForm({ 
                url: '/login',
                dataType: 'text',
                success: function(data) {
                    data = $.parseJSON(data);
                    switch(data.status) {
                        case 'error':
                          message(data.error, 'danger');
                          $('button[type=submit]').prop('disabled', false);                                               
                            break;
                        case 'success': 
                            document.getElementById("l-login").className = 'lc-block toggled animated fadeOutDown'; 
                            $('.login-content').hide (function () { });
                            setTimeout (function (){location.href = (location.href + '?auth');}, 800);
                            break;
                    }
                },
                beforeSubmit: function(arr, $form, options) {
                    $('button[type=submit]').prop('disabled', true);
                }
            });

            $('#l-forget-password').ajaxForm({ 
                url: location.pathname,
                dataType: 'text',
                success: function(data) {
                    data = $.parseJSON(data);
                    switch(data.status) {
                        case 'error':
                          message(data.error, 'danger');
                          $('button[type=submit]').prop('disabled', false);                                               
                            break;
                        case 'success':
                            message(data.success, 'success');
                            location.href = "/";
                            $('button[type=submit]').prop('disabled', false); 
                            break;
                    }
                },
                beforeSubmit: function(arr, $form, options) {
                    $('button[type=submit]').prop('disabled', true);
                }
            });

            $('#l-register').ajaxForm({ 
                url: '/reg',
                dataType: 'text',
                success: function(data) {
                    data = $.parseJSON(data);
                    switch(data.status) {
                        case 'error':
                          message(data.error, 'danger');
                          $('button[type=submit]').prop('disabled', false);                                               
                            break;
                        case 'success':
                            message(data.success, 'success');
                            $(".lc-block").removeClass("toggled");
                            $("#l-login").addClass("toggled");
                            $("#input-login").val($("#reg-login").val());
                            $('button[type=submit]').prop('disabled', false); 
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