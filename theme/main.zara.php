@inject("maksa", "Maksa")
@if(empty($maksa->registry->request->post['ajax']))
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LocalPay.ru - Личный кабинет для партнёров</title>

        <!-- CSS -->
        <link href="/assets/vendors/animate-css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/app.min.css" rel="stylesheet">
        <link href="/assets/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed&subset=latin,cyrillic' rel='stylesheet'>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="shortcut icon" href="http://localpay.ru/favicon.ico" />
        <!-- Javascript Libraries -->
        <script src="/assets/js/jquery-2.1.1.min.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>

        <script src="/assets/vendors/flot/jquery.flot.min.js"></script>
        <script src="/assets/vendors/flot/jquery.flot.resize.min.js"></script>
        <script src="/assets/vendors/flot/plugins/curvedLines.js"></script>
        <script src="/assets/vendors/sparklines/jquery.sparkline.min.js"></script>
        <script src="/assets/vendors/easypiechart/jquery.easypiechart.min.js"></script>

        <script src="/assets/vendors/nicescroll/jquery.nicescroll.min.js"></script>
        <script src="/assets/vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
        <script src="/assets/vendors/sweet-alert/sweet-alert.min.js"></script>
        <script src="/assets/vendors/bootgrid/jquery.bootgrid.min.js"></script>
        <script src="/assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="/assets/js/jquery.form.js"></script> 
        <script src="/assets/vendors/waves/waves.min.js"></script>
        <script src="/assets/vendors/fileinput/fileinput.min.js"></script>

        <script src="/assets/js/functions.js"></script>
        <script src="//vk.com/js/api/openapi.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="preloader-site">
            <div class="preloader pls-blue pl-xxl" style="position: absolute; top: 38%; left: 46%;">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                </svg>
            </div>
        </div>
        <div id="loading-page">
            <div class="preloader pls-blue pl-lg">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"></circle>
                </svg>
            </div>
        </div>
        <header id="header">
            <ul class="header-inner">
                <li id="menu-trigger" data-trigger="#sidebar">
                    <div class="line-wrap">
                        <div class="line top"></div>
                        <div class="line center"></div>
                        <div class="line bottom"></div>
                    </div>
                </li>

                <li class="logo hidden-xs">
                    <a href="/profile">CP.LOCALPAY - ЛИЧНЫЙ КАБИНЕТ</a>
                </li>

                <li class="pull-right">
                <ul class="top-menu">
                   <!--  <li class="hidden-xs">
                        <a target="_blank" href="http://wrapbootstrap.com/theme/superflat-simple-responsive-admin-theme-WB082P91H">
                            <span class="tm-label">Link</span>
                        </a>
                    </li> -->
                    <!-- <li class="dropdown">
                        <a data-toggle="dropdown" class="tm-notification" href="#"><i class="tmn-counts">9</i></a>
                        <div class="dropdown-menu dropdown-menu-lg pull-right">
                            <div class="listview" id="notifications">
                                <div class="lv-header">
                                    Оповещения

                                    <ul class="actions">
                                        <li class="dropdown">
                                            <a href="#" data-clear="notification">
                                                <i class="md md-done-all"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </li> -->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="tm-settings" href="#"></a>
                        <ul class="dropdown-menu dm-icon pull-right">
                            <li>
                                <a href="/profile"><i class="md md-person"></i> Мой профиль</a>
                            </li>
                            <li>
                                <a href="/logout"><i class="md md-exit-to-app"></i> Выйти из ЛК</a>
                            </li>
                        </ul>
                    </li>
                    </ul>
                </li>
            </ul>
        </header>

        <section id="main">
            <aside id="sidebar">
                <div class="sidebar-inner">
                    <div class="si-inner">
                        <div class="profile-menu">
                            <a href="/profile">
                                <div class="profile-pic">
                                    <img src="{{ $maksa->user($maksa->registry->session->data['user_id'])['user_avatar'] }}" alt="">
                                </div>

                                <div class="profile-info">
                                    {{ $maksa->user($maksa->registry->session->data['user_id'])['user_firstname'] }} {{ $maksa->user($maksa->registry->session->data['user_id'])['user_lastname'] }}
                                    <div class="pull-right" id="user_balance">{{ (float) $maksa->user($maksa->registry->session->data['user_id'])['user_balance'] }} руб.</div>
                                </div>
                            </a>
                        </div>

                        <ul class="main-menu">
                            <li class="sub-menu">
                                <a href="#"><i class="md md-web"></i> Мои проекты</a>
                                <ul>
                                    @foreach($maksa->projects as $item)
                                    <li><a href="/project/{{ $item['shop_id'] }}"><i class="md md-shopping-cart"></i> {{ $item['shop_name'] }}</a></li>
                                    @endforeach
                                    <li><a class="active" href="/project/add"><i class="md md-add"></i> Добавить проект</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="/money"><i class="fa fa-rub fa-fw" style="margin-top: 4px"></i> Вывод средств</a>
                            </li>
                            <li class="sub-menu">
                                <a href="#"><i class="md md-live-help"></i>Поддержка</a>
                                
                                <ul>
                                    <li><a href="/support"><i class="md md-help"></i> Мои запросы</a></li>
                                    <li><a class="active" href="/support/new"><i class="md md-add-box"></i> Создать запрос</a></li>
                                </ul>
                            </li>
							<li>
                                <a href="http://help.localpay.ru/"><i class="md md-insert-drive-file" style="margin-top: 4px"></i> Центр помощи</a>
                            </li>
							<li>
                                <a href="http://localpay.ru/"><i class="fa fa-paper-plane" style="margin-top: 4px"></i> Официальный сайт</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </aside>

            <section id="content">
                @yield("content")
            </section>
        </section>
    </body>
</html>
@else
    @yield("content")
@endif