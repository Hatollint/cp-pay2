@extends("main")
@section("content")
<div class="container">
    <div class="card">
        <div class="row tab" role="tabpanel">
            <div class="col-lg-12">
                <div class="panel-body shop-head" style="background-image: url('http://cp.localpay.ru/images/{{ $cat[$project['shop_game']] }}_header.png')">
                    <div class="game-name">
                        {{ $project['shop_name'] }}
                        <p>{{ $project['shop_domain'] }}</p>
                    </div>
                    <div class="site-balance">
                        Общий доход проекта
                        <p>{{ (float)$project['shop_balance'] }} <i class="fa fa-rub"></i></p>
                    </div>
                </div>
                <ul class="tab-nav" role="tablist" tabindex="3" style="overflow: hidden; outline: none;">
                    <li class="active"><a href="#stats" aria-controls="stats" role="tab" data-toggle="tab" aria-expanded="true">Статистика</a></li>
                    <li role="presentation" class=""><a href="#items" aria-controls="items" role="tab" data-toggle="tab" aria-expanded="false">Платежи</a></li>
                    <li role="presentation" class=""><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false">Настройки</a></li>
                    <li role="presentation" class=""><a href="#pays" aria-controls="pays" role="tab" data-toggle="tab" aria-expanded="false">Платежные системы</a></li>
                    <li role="presentation" class=""><a href="#form" aria-controls="form" role="tab" data-toggle="tab" aria-expanded="false">Форма оплаты</a></li>
                    
                    <li role="presentation" class="pull-right"><a href="#moder" aria-controls="moder" role="tab" data-toggle="tab" aria-expanded="false">
						@if($project['shop_status'] == 0)
	                   	<span class="label label-warning">Ожидает модерации</span>
	                   	@elseif($project['shop_status'] == 1)
	                   	<span class="label label-success">Одобрен</span>
	                   	@elseif($project['shop_status'] == 2)
	                   	<span class="label label-danger">Заблокирован</span>
	                   	@elseif($project['shop_status'] == 3)
	                   	<span class="label label-info">Ожидает подтверждения</span>
	                   	@endif
                    </a></li>
                </ul>
            </div>
			<div class="tab-content">
				<div class="col-lg-12 tab-pane animated fadeInUp @if($project['shop_status'] == 0 or $project['shop_status'] == 2 or $project['shop_status'] == 3) active @endif " style="margin-top: 20px;" role="tabpanel" id="moder">
					@if($project['shop_status'] == 0)
           	<div class="col-sm-12">
                <div class="card">
                    <div class="card-body card-padding bgm-orange c-white">
                        Ваш проект ожидает прохождения модерации нашими модераторами.<br>
                        Подробнее о модерации вы можете прочитать в нашем центре помощи - <a href="http://help.localpay.ru/article/moderation-project" style="color: #EFEFEF;">http://help.localpay.ru/article/moderation-project</a>
                    </div>
                </div>
            </div>
           	@elseif($project['shop_status'] == 1)
           	<div class="col-sm-12">
                <div class="card">
                    <div class="card-body card-padding bgm-green c-white">
                        Ваш проект был одобрен и вы можете пользоваться всеми функциями сервиса.<br>
                        Если вам нужна помощь вы можете найти некоторые ответы в нашем <a href="http://help.localpay.ru/" style="color: #EFEFEF;">центре помощи</a>, если вы не найдете ответ вы можете обратиться в нашу <a href="/support" style="color: #EFEFEF;">поддержку</a>.
                    </div>
                </div>
            </div>
           	@elseif($project['shop_status'] == 2)
           	<div class="col-sm-12">
                <div class="card">
                    <div class="card-body card-padding bgm-red c-white">
                        Ваш проект был проверен нашими модераторами и был отклонен в связи с несоотвествием правил.<br>
                        Сообщение от модератора: <u>{{ $project['shop_reason'] }}</u>
                    </div>
                </div>
            </div>
           	@elseif($project['shop_status'] == 3)
           	<div class="col-sm-12">
                <div class="card">
                    <div class="card-body card-padding bgm-blue c-white">
                        При добавлении проекта вы не завершили второй этап (проверка сайта) добавления.<br>
                        <a href="/project/add/{{ $project['shop_id'] }}" style="color: #EFEFEF;">Закончить добавление сайта.</a>
                    </div>
                </div>
            </div>
           	@endif
				</div>

	            <div class="col-lg-12 tab-pane animated fadeInUp @if($project['shop_status'] == 1) active @endif" style="margin-top: 20px;" role="tabpanel" id="stats">
	            	<div class="col-sm-4">
	                    <div class="mini-charts-item bgm-lightgreen">
	                        <div class="clearfix">
	                            <div class="chart stats-bar-2"><canvas width="83" height="45" style="display: inline-block; width: 83px; height: 45px; vertical-align: top;"></canvas></div>
	                            <div class="count">
	                                <small>Доход за сегодня</small>
	                                <h2>{{ (float)$stats[3][0]['sum'] }} <i class="fa fa-rub"></i></h2>
	                            </div>
	                        </div>
	                    </div>
	                </div>
				    <div class="col-sm-4">
	                    <div class="mini-charts-item bgm-bluegray">
	                        <div class="clearfix">
	                            <div class="chart stats-line"><canvas width="83" height="45" style="display: inline-block; width: 83px; height: 45px; vertical-align: top;"></canvas></div>
	                            <div class="count">
	                                <small>Доход за неделю</small>
	                                <h2>{{ (float)$stats[4][0]['sum'] }} <i class="fa fa-rub"></i></h2>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="col-sm-4">
	                    <div class="mini-charts-item bgm-orange">
	                        <div class="clearfix">
	                            <div class="chart stats-bar-2"><canvas width="83" height="45" style="display: inline-block; width: 83px; height: 45px; vertical-align: top;"></canvas></div>
	                            <div class="count">
	                                <small>Всего платежей</small>
	                                <h2>{{ $stats[5] }}</i></h2>
	                            </div>
	                        </div>
	                    </div>
	                </div>

	                <div class="col-md-6">
	                    <div class="card" style="border: 1px solid rgba(204, 204, 204, 0.48); box-shadow: none;">
	                        <div class="card-header">
	                            <h2>Статистика платежей
									<small>Платежи за последние 7 дней</small>
	                            </h2>
	                        </div>
	                    
	                        <div class="card-body">
	                            <div class="chart-edge">
	                            	<div id="payments-stats" class="flot-chart"></div>    
	                          	</div>
	                        </div>
	                    </div>
	                </div>

	                <div class="col-md-6">
	                    <div class="card" style="border: 1px solid rgba(204, 204, 204, 0.48); box-shadow: none;">
	                        <div class="card-header">
	                            <h2>Статистика дохода
									<small>Доход за последние 7 дней</small>
	                            </h2>
	                        </div>
	                    
	                        <div class="card-body">
	                            <div class="chart-edge">
	                            	<div id="money-stats" class="flot-chart"></div>    
	                          	</div>
	                        </div>
	                    </div>
	                </div>
	            </div>

	            <div class="col-lg-12 tab-pane animated fadeInUp" style="margin-top: 20px;" role="tabpanel" id="items">
	            	<table id="data-table-command" class="table table-striped bootgrid-table" aria-busy="false">
		                <thead>
		                    <tr>
		                        <th data-column-id="id" class="text-left" data-type="numeric">#</th>
		                        <th data-column-id="time" class="text-left">Дата</th>
		                        <th data-column-id="system" class="text-left">Система</th>
		                        <th data-column-id="invoice" class="text-left">№ Счета</th>
		                        <th data-column-id="sum" data-formatter="sum" class="text-left">Сумма</th>
		                        <th data-column-id="addsum" data-formatter="addsum" class="text-left">Доход</th>
		                        <th data-column-id="status" data-formatter="status" class="text-left">Статус</th>
		                        <th data-column-id="commands" data-formatter="commands" data-sortable="false"></th>
		                    </tr>
		                </thead>
		                <tbody>
		                	<? $id = 0 ?>
		                    @foreach($items as $item)
		                    <? $id++ ?>
		                    <tr>
		                        <td>{{ $item['log_payments_id'] }}</td>
		                        <td>{{ date("d.m.Y", strtotime($item['log_payments_time'])) }}</td>
		                        <td>{{ $item['log_payments_system'] }}</td>
		                        <td>{{ $item['user_id'] }}</td>
		                        <td>{{ $item['log_payments_sum'] }} <i class="fa fa-rub"></i></td>
		                        <td>{{ (float)$item['log_payments_sum_client'] }}</td>
		                        <td>{{ $item['log_payments_status'] }}</td>
		                    </tr>
		                    @endforeach
		                </tbody>
		            </table>
	            </div>

	            <div class="col-lg-12 tab-pane animated fadeInUp" style="margin-top: 20px; padding: 20px 35px;" role="tabpanel" id="settings">
		          <form class="col-sm-6" method="POST" action="#" id="generalInfo">                       
                    <ul class="tab-nav" style="overflow: hidden; outline: none; margin-top: -30px; margin-bottom: 35px;">
                      <li><a href="#">Основная информация</a></li>
                    </ul>
                    <div class="form-group fg-float">
                        <div class="fg-line fg-toggled">
                            <input type="text" class="input-sm form-control fg-input" name="shop_name" value="{{ $project['shop_name'] }}">
                        </div>
                        <label class="fg-label">Название проекта</label>
                    </div>

                    <br>
                    
                    <div class="form-group fg-float">
                        <div class="fg-line fg-toggled">
                            <select class="input-sm form-control fg-input" name="shop_game">
                              <option value="0" selected disabled>Выберите категорию</option>
                              <option value="1" @if($project['shop_game'] == 1) selected @endif>Интернет-магазин</option>
                              <option value="2" @if($project['shop_game'] == 2) selected @endif>Игровой сервер</option>
                              <option value="3" @if($project['shop_game'] == 3) selected @endif>Steam-проект</option>
                              <option value="4" @if($project['shop_game'] == 4) selected @endif>Другое</option>
                            </select>
                        </div>
                        <label class="fg-label">Игра</label>
                    </div>
                    
                    <br>

                    <ul class="tab-nav" style="overflow: hidden; outline: none; margin-top: -30px; margin-bottom: 35px;">
                      <li><a href="#">Уведомления</a></li>
                    </ul>

                    <div class="form-group checkbox m-b-15" style="margin-top: -20px;">
                        Вы можете включить уведомление на ваш E-mail адрес в случае успешной оплаты в вашем магазине.
                        <br><br>
                        <label>
                            <input type="checkbox" name="notif" value="on" @if($project['shop_notify']) checked @endif >
                            <i class="input-helper"></i>
                            Включить уведомления на E-mail
                        </label>
                    </div>

                    <br>

                    <div class="input-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <div class="fg-line">    
                                <input type="hidden" name="generalInfo" value="true">
                                <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="col-sm-6" method="POST" action="#" id="otherInfo">                       
                    <ul class="tab-nav" style="overflow: hidden; outline: none; margin-top: -30px; margin-bottom: 35px;">
                      <li><a href="#">Данные проекта</a></li>
                    </ul>
                    <div class="input-group fg-float">
                        <div class="fg-line fg-toggled disabled">
                            <input type="text" class="input-sm form-control fg-input" id="shop_secret_key" value="{{ $project['shop_secret_key'] }}" disabled>
                        </div>
                        <label class="fg-label">Секретный ключ</label>
                        <span class="input-group-addon"><i class="fa fa-edit" id="new_secret" data-toggle="tooltip" data-placement="left" title="Сгенерировать новый"></i></span>
                    </div>

                    <br><br>

                    <div class="input-group fg-float">
                        <div class="fg-line fg-toggled disabled">
                            <input type="text" class="input-sm form-control fg-input" id="shop_public_key" value="{{ $project['shop_public_key'] }}" disabled>
                        </div>
                        <label class="fg-label">Публичный ключ</label>
                        <span class="input-group-addon"><i class="fa fa-edit" id="new_public" data-toggle="tooltip" data-placement="left" title="Сгенерировать новый"></i></span>
                    </div>

                    <br>
                    <br>
                    <br>
                    
                    <ul class="tab-nav" style="overflow: hidden; outline: none; margin-top: -30px; margin-bottom: 35px;">
                      <li><a href="#">Обработчик</a></li>
                    </ul>

                    <div class="input-group fg-float">
                        <div class="fg-line fg-toggled disabled">
                            <input type="text" class="input-sm form-control fg-input" id="shop_url" name="shop_url" value="{{ $project['shop_url'] }}" onChange="changeURL()">
                        </div>
                        <label class="fg-label">Адрес обработчика</label>
                        <span class="input-group-addon" id="url_status">
                          <div class="label label-danger" data-toggle="tooltip" data-placement="top" title="Ошибка">
                            <i class="fa fa-remove"></i>
                          </div>
                        </span>
                        <span class="input-group-addon" id="url_status">
                          <button type="button" class="btn btn-xs" onClick="$('#check_request_modal').modal('show');"><span class="md md-repeat"></span></button>
                        </span>
                    </div>

                    <br><br><br>

                    <ul class="tab-nav" style="overflow: hidden; outline: none; margin-top: -30px; margin-bottom: 35px;">
                      <li><a href="#">Переадресация</a></li>
                    </ul>

                    <div class="form-group fg-float" style="margin-top: -20px;">
                        Если Ваш проект содержит специальные страницы на случай успешного платежа или ошибки оплаты заказа, рекомендуем активировать эту возможность и указать URL таких страниц. 
                        <br><br>
                        <small>Если вы оставите поля пустыми, переадрессация будет производиться на сайт вашего проекта</small>
                    </div>

                    <div class="form-group fg-float">
                        <div class="fg-line fg-toggled disabled">
                            <input type="text" class="input-sm form-control fg-input" name="shop_fail_url" value="{{ $project['shop_fail_url'] }}" onChange="changeURL()">
                        </div>
                        <label class="fg-label">Fail URL</label>
                    </div>

                    <div class="form-group fg-float">
                        <div class="fg-line fg-toggled disabled">
                            <input type="text" class="input-sm form-control fg-input" name="shop_success_url" value="{{ $project['shop_success_url'] }}" onChange="changeURL()">
                        </div>
                        <label class="fg-label">Success URL</label>
                    </div>

                    <div class="input-group">
                        <div class="col-sm-8 col-sm-offset-4">
                            <div class="fg-line">    
                                <input type="hidden" name="otherInfo" value="true">
                                <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Сохранить</button>
                            </div>
                        </div>
                    </div>
                </form>
	            </div>

	            <div class="col-lg-12 tab-pane animated fadeInUp" style="margin-top: 20px;" role="tabpanel" id="form">
					       <div class="col-lg-6">
                    <ul class="tab-nav" role="tablist" tabindex="3" style="overflow: hidden; outline: none;">
	                     <li class="active"><a href="#url" aria-controls="stats" role="tab" data-toggle="tab" aria-expanded="true">Ссылка оплаты</a></li>
	                     <li role="presentation" class=""><a href="#formcode" aria-controls="items" role="tab" data-toggle="tab" aria-expanded="false">HTML форма</a></li>
            		    </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane well active" id="url">
                          http://api.localpay.ru/pay?public_key=<span class="alert-info">{{ $project['shop_public_key'] }}</span>&amp;<span class="alert-success">sum</span>=10&amp;<span class="alert-success">account</span>=demo&amp;<span class="alert-success">desc</span>=Описание+платежа
                        </div>
                        <div role="tabpanel" class="tab-pane well" id="formcode">
                            &lt;form action="http://api.localpay.ru/pay"&gt;<br>
                          &lt;input type="hidden" name="public_key" value="<span class="alert-info">{{ $project['shop_public_key'] }}</span>"&gt;<br>
                          &lt;input type="text" <span class="alert-success">name="account"</span> value="test"&gt;<br>
                          &lt;input type="text" <span class="alert-success">name="sum"</span> value="50"&gt;<br>
                          &lt;input type="hidden" <span class="alert-success">name="desc"</span> value="Описание платежа"&gt;<br>
                          &lt;input class="btn" type="submit" value="Оплатить"&gt;<br>
                          &lt;/form&gt;
                        </div>
                      </div>
                  </div>
                  <div class="col-lg-6">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td class="span3" style="border-top: none"><span class="label label-success">:sum</span></td>
                          <td class="text-medium" style="border-top: none">Сумма платежа (например, 10)</td>
                        </tr>
                        <tr>
                          <td class="span2" style="border-top: 1px solid #eee"><span class="label label-success">:account</span></td>
                          <td class="text-medium" style="border-top: 1px solid #eee">Идентификатор абонента в системе партнера <br>(например email абонента или номер заказа)</td>
                        </tr>
                        <tr>
                          <td class="span2" style="border-top: 1px solid #eee"><span class="label label-success">:desc</span></td>
                          <td class="text-medium" style="border-top: 1px solid #eee">Описание заказа</td>
                        </tr>
                        <tr>
                          <td class="span2" style="border-top: 1px solid #eee"><span class="label label-default">:sign</span></td>
                          <td class="text-medium" style="border-top: 1px solid #eee"><a target="_blank" href="http://help.localpay.ru/article/creating-payment">Цифровая подпись запроса</a>.
                              Формируется как md5 хеш результата склеивания параметров: account, currency, desc, sum и
                              <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false">SECRET KEY</a>.
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
	            </div>

                <div class="col-lg-12 tab-pane animated fadeInUp" style="margin-top: 20px;" role="tabpanel" id="pays">
                   <style>
                        a.item-paysystem {
                                display: inline-block;
                                width: auto;
                                cursor: pointer;
                                margin: 0px 5px;
                                border: 1px solid #DFDFDF;
                                margin-bottom: 15px;
                        }
                            a.item-paysystem.disabled {
                                opacity: 0.3;
                            }
                   </style>
                   <div class="col-lg-12">
                    <a href="#pays" class="item-paysystem @if($project['shop_webmoney'] != 1) disabled @endif" data-system="webmoney"><img src="http://api.localpay.ru/systems/webmoney.png">
                    @if($project['shop_webmoney'] == 2)<span class="label label-primary" style="position: absolute; margin-left: 93px; margin-top: -61px;">Ожидает ответа</span>@endif
                    @if($project['shop_webmoney'] == 3)<span class="label label-danger" style="position: absolute; margin-left: 101px; margin-top: -61px;">Заблокирован</span>@endif
                    @if($project['shop_webmoney'] == 4)<span class="label label-danger" style="position: absolute; margin-left: 39px; margin-top: -61px;">Нет персонального аттестата</span>@endif
                    </a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_yandex']) disabled @endif" data-system="yandex"><img src="http://api.localpay.ru/systems/yandex.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_qiwi']) disabled @endif" data-system="qiwi"><img src="http://api.localpay.ru/systems/qiwi.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_visa']) disabled @endif" data-system="visa"><img src="http://api.localpay.ru/systems/visa.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_master_card']) disabled @endif" data-system="master_card"><img src="http://api.localpay.ru/systems/master-card.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_robokassa']) disabled @endif" data-system="robokassa"><img src="http://api.localpay.ru/systems/robokassa.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_ooopay']) disabled @endif" data-system="ooopay"><img src="http://api.localpay.ru/systems/oopay.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_tinkoff']) disabled @endif" data-system="tinkoff"><img src="http://api.localpay.ru/systems/tinkoff.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_w1']) disabled @endif" data-system="w1"><img src="http://api.localpay.ru/systems/w1.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_payeer']) disabled @endif" data-system="payeer"><img src="http://api.localpay.ru/systems/payeer.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_okpay']) disabled @endif" data-system="okpay"><img src="http://api.localpay.ru/systems/okpay.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_zpayment']) disabled @endif" data-system="zpayment"><img src="http://api.localpay.ru/systems/zpayment.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_alpha_bank']) disabled @endif" data-system="alpha_bank"><img src="http://api.localpay.ru/systems/alpha-bank.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_sberbank']) disabled @endif" data-system="sberbank"><img src="http://api.localpay.ru/systems/sberbank.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_vtb']) disabled @endif" data-system="vtb"><img src="http://api.localpay.ru/systems/vtb.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_promsvyazbank']) disabled @endif" data-system="promsvyazbank"><img src="http://api.localpay.ru/systems/promsvyazbank.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_rus_standart']) disabled @endif" data-system="rus_standart"><img src="http://api.localpay.ru/systems/rus-standart.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_mts']) disabled @endif" data-system="mts"><img src="http://api.localpay.ru/systems/mts.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_tele2']) disabled @endif" data-system="tele2"><img src="http://api.localpay.ru/systems/tele2.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_beline']) disabled @endif" data-system="beline"><img src="http://api.localpay.ru/systems/beline.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_terminal_ru']) disabled @endif" data-system="terminal_ru"><img src="http://api.localpay.ru/systems/terminal-ru.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_terminal_ua']) disabled @endif" data-system="terminal_ua"><img src="http://api.localpay.ru/systems/terminal-ua.png"></a>
                    <a href="#pays" class="item-paysystem @if(!$project['shop_mykassa']) disabled @endif" data-system="mykassa"><img src="http://api.localpay.ru/systems/mykassa.png"></a>
                  </div>
                </div>
	        </div>
        </div>

    </div>
</div>

@foreach($items as $item)
<div class="modal fade" id="detail-{{ $item['log_payments_id'] }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Детали платежа #{{ $item['log_payments_id'] }}</h4>
        </div>
        <div class="modal-body">
          <? $sign = md5($item['user_id'].$item['log_payments_sum'].$project['shop_secret_key'])?>
          @if($item['log_payments_status'] >= 2) 
          <div id="requests-{{ $item['log_payments_id'] }}" style="display: none">
            <div class="well well-sm" style="word-wrap: break-word;">
            <span class="label label-success">Запрос</span><hr style="margin: 5px 0">
            {{ $project['shop_url'] }}?<br>
            method=check&amp;params[account]={{ $item['user_id'] }}&amp;params[projectId]={{ $item['shop_id'] }}&amp;params[sum]={{ $item['log_payments_sum'] }}&amp;params[sign]={{ $sign}}&amp;params[localpayId]={{ $item['log_payments_id'] }}
            </div>
            <div class="well well-sm" style="word-wrap: break-word; text-align: right">
            <span class="label label-success" style="clear: right">Ответ</span><hr style="margin: 5px 0">
            {"jsonrpc":"2.0","result":{"message":"CHECK is successful"},"id":1}
            </div>
            <div class="well well-sm" style="word-wrap: break-word;">
            <span class="label label-success">Запрос</span><hr style="margin: 5px 0">
            {{ $project['shop_url'] }}?<br>
            method=pay&amp;params[account]={{ $item['user_id'] }}&amp;params[projectId]={{ $item['shop_id'] }}&amp;params[sum]={{ $item['log_payments_sum'] }}&amp;params[sign]={{ $sign}}&amp;params[localpayId]={{ $item['log_payments_id'] }}
            </div>
            <div class="well well-sm" style="word-wrap: break-word; text-align: right">
            <span class="label label-success" style="clear: right">Ответ</span><hr style="margin: 5px 0">
            {"jsonrpc":"2.0","result":{"message":"Pay is successful"},"id":1}
            </div>
          </div>
          @elseif($item['log_payments_status'] == 0)
          <div id="requests-{{ $item['log_payments_id'] }}" style="display: none">
            <div class="well well-sm" style="word-wrap: break-word;">
            <span class="label label-success">Запрос</span><hr style="margin: 5px 0">
            {{ $project['shop_url'] }}?<br>
            method=check&amp;params[account]={{ $item['user_id'] }}&amp;params[projectId]={{ $item['shop_id'] }}&amp;params[sum]={{ $item['log_payments_sum'] }}&amp;params[sign]={{ $sign }}&amp;params[localpayId]={{ $item['log_payments_id'] }}
            </div>
            <div class="well well-sm" style="word-wrap: break-word; text-align: right">
            <span class="label label-success" style="clear: right">Ответ</span><hr style="margin: 5px 0">
            {"jsonrpc":"2.0","result":{"message":"CHECK is successful"},"id":1}
            </div>
          </div>
          @else
          <div id="requests-{{ $item['log_payments_id'] }}" style="display: none">
            <div class="well well-sm" style="word-wrap: break-word;">
            <span class="label label-success">Запрос</span><hr style="margin: 5px 0">
            {{ $project['shop_url'] }}?<br>
            method=check&amp;params[account]={{ $item['user_id'] }}&amp;params[projectId]={{ $item['shop_id'] }}&amp;params[sum]={{ $item['log_payments_sum'] }}&amp;params[sign]={{ $sign }}&amp;params[localpayId]={{ $item['log_payments_id'] }}
            </div>
            <div class="well well-sm" style="word-wrap: break-word; text-align: right">
            <span class="label label-danger" style="clear: right">Ответ</span><hr style="margin: 5px 0">
            {"jsonrpc":"2.0","error":{"code":-32000,"message":"Character not found!"},"id":1}
            </div>
          </div>
          @endif
          <div class="btn btn-primary btn-xs open" data-id="{{ $item['log_payments_id'] }}">Показать подробности</div>
          <br><br>Система оплаты: <b>{{ $item['log_payments_system'] }}</b>
          <br>Время создания платежа: <b>{{ date("d.m.Y в H:i", strtotime($item['log_payments_time'])) }}</b>
          @if($item['log_payments_status'] >= 2) 
          <br>Время оплаты платежа: <b>{{ date("d.m.Y в H:i", strtotime($item['log_payments_time_complete'])) }}</b>
          @else
          <br>Время оплаты платежа: <b>Неоплачен</b>  
          @endif
          <br>№ счета: <b>{{ $item['user_id'] }}</b>
          <br>Сумма платежа: <b>{{ $item['log_payments_sum'] }} <i class="fa fa-rub"></i></b>
          <br>Ваш доход: <b><small>+</small>{{ $item['log_payments_sum_client'] }} <i class="fa fa-rub"></i> ({{ floor($item['log_payments_sum_client']*100/$item['log_payments_sum']) }}%)</b>
        </div>
      </div>
    </div>
	</div>
@endforeach
<div class="modal fade" id="check_request_modal" tabindex="-1" role="dialog" aria-labelledby="check_request_modalLabel">
	<div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="check_request_modalLabel">Тестовый запрос</h4>
        </div>
        <div class="modal-body">
        	<br>
        	<div class="col-sm-6">                       
                <div class="form-group fg-float">
                    <div class="fg-line fg-toggled">
                        <select class="input-sm form-control fg-input" id="method">
                          <option value="check">CHECK</option>
                          <option value="pay">PAY</option>
                        </select>
                    </div>
                    <label class="fg-label">Метод оплаты</label>
                </div>
				
				<br>

                <div class="form-group fg-float">
                    <div class="fg-line fg-toggled">
                        <input type="text" class="input-sm form-control fg-input" id="account" value="test">
                    </div>
                    <label class="fg-label">Номера счета</label>
                </div>
            </div>
            <div class="col-sm-6">                       
                
                <div class="form-group fg-float">
                    <div class="fg-line fg-toggled">
                        <input type="text" class="input-sm form-control fg-input" id="sum" value="10">
                    </div>
                    <label class="fg-label">Сумма платежа</label>
                </div>
            </div>
            <br><br>
            <br><br>
            <br><br>
            <br><br>
            <div class="form-group fg-float">
                <div class="fg-line fg-toggled">
                    <input type="text" class="input-sm form-control fg-input" id="request_url">
                </div>
                <label class="fg-label">Запрос к серверу</label>
            </div>
            
            <textarea id="response_result" cols="30" rows="3" class="form-control" placeholder="Ответ от сервера"></textarea><br>
            <button class="btn btn-primary btn-sm hec-button waves-effect waves-button" id="send_check_request">Отправить запрос</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="webmoney_request_modal" tabindex="-1" role="dialog" aria-labelledby="webmoney_request_modalLabel">
	<div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="webmoney_request_modalLabel">Запрос на подключение WebMoney</h4>
        </div>
        <div class="modal-body">
			Для того что бы подключить WebMoney вам необходимо иметь персональный аттестат, если у вас такого нет попытка подать заявку на подключение WebMoney будет отклонена и использовано напрасно, учитывайте и то что если ваша заявка была отклонена подать повторно можно будет ее только через месяц.<br><br>
			Так же перед подачей заявки рекомендуем вам проверить правильность введенного вами кошелька от WebMoney в личном профиле, в противном случае ваша заявка будет отклонена.<br><br>
			Заявки после нашей обработки подаються на рассмотрение МегаСтока, каждый сайт подключаеться отдельно. Приблизительное время ответа от МегаСтока: 5-6 дней. Как только мы получаем ответ от них, вы получаете ответ от нас в виде изменения статуса заявки подключения WebMoney который отображается в углу иконки метода оплаты WebMoney в панеле управления.<br><br>
			<center><button class="btn btn-primary btn-sm hec-button waves-effect waves-button" id="send_wm_request">Отправить запрос</button></center>
        </div>
      </div>
    </div>
</div>

<script src="/assets/js/flot-charts/line-chart.js"></script>
<script src="/assets/js/charts.js"></script>
<script>
	$("#data-table-command").bootgrid({
        css: {
            icon: 'md icon',
            iconColumns: 'md-view-module',
            iconDown: 'md-expand-more',
            iconRefresh: 'md-refresh',
            iconUp: 'md-expand-less'
        },
        formatters: {
            "commands": function(column, row) {
                return "<button type=\"button\" class=\"btn btn-xs command-list\" onClick=\"$('#detail-"+ row.id +"').modal('show');\"><span class=\"md md-list\"></span></button>";
            },
            "addsum": function(column, row) {
            	return '<small>+</small>'+ row.addsum +' <i class="fa fa-rub"></i>';
            },
            "sum": function(column, row) {
            	return row.sum +' <i class="fa fa-rub"></i>';
            },
            "status": function(column, row) {

                if(row.status == 0){
                    return '<span class="label label-warning">В процессе</span>';
                } 
                if(row.status == 1){
                    return '<span class="label label-danger">Ошибка</span>';
                } 
                if(row.status >= 2){
                    return '<span class="label label-success">Оплачен</span>';
                } 

            }
        }
    });

    if({{ $id }} <= 10){
        $("#data-table-basic-command").remove();
    }
    // $("#data-table-command-header").remove();

    var options = {
        series: {
            shadowSize: 0,
            lines: {
                show: false,
                lineWidth: 0,
            },
        },
        grid: {
            borderWidth: 0,
            labelMargin:10,
            hoverable: true,
            clickable: true,
            mouseActiveRadius:6,
            
        },
        xaxis: {
            tickDecimals: 0,
            ticks: false
        },
        
        yaxis: {
            tickDecimals: 0,
            ticks: false
        },
        
        legend: {
            show: false
        }
    };

    <?php $id = 0 ?>
    <?php $ids = 0 ?>

    var d1 = [];
    @foreach($stats[1] as $item)
        d1.push([{{ $id++ }}, {{ (int)$item['stat'] }}]);
    @endforeach
    var d2 = [];
 	  @foreach($stats[2] as $item)
        d2.push([{{ $ids++ }}, {{ (float)$item['sum'] }}]);
    @endforeach   

    $.plot($("#payments-stats"), [
        {data: d1, lines: { show: true, fill: 0.98 }, label: 'Платежей', stack: true, color: '#f1dd2c' }
    ], options);

    $.plot($("#money-stats"), [
        {data: d2, lines: { show: true, fill: 0.98 }, label: 'Доход', stack: true, color: '#e3e3e3' },
    ], options);

    $(".open").click(function(){
        $("#requests-" + $(this).attr("data-id")).css("display", "block");
        $(this).css("display", "none");
  	});

    $(".item-paysystem").click(function(){
        var paySystem = $(this).attr("data-system");
        @if($project['shop_webmoney'] == 0) if(paySystem == "webmoney") {
        	$("#webmoney_request_modal").modal("show");
        } else { @endif
        	$.ajax({
	            url: location.pathname,
	            type: "POST",
	            data: {ajax: "paySystem", system: paySystem},
	            success: function(data){
	                data = $.parseJSON(data);
	                switch(data.status) {
	                    case 'error':
	                        message(data.error, 'danger');
	                        break;
	                    case 'success':
	                        message(data.success, 'success');
	                        if(data.type == 1) {
	                            $('.item-paysystem[data-system='+ paySystem +']').removeClass("disabled");
	                        } 
	                        if(data.type == 0) {
	                            $('.item-paysystem[data-system='+ paySystem +']').addClass("disabled");
	                        }
	                        break;
	                }
	            }
	        });
        @if($project['shop_webmoney'] == 0) } @endif
    });

    $("#send_check_request").click(function(){

        $.ajax({
            url: location.pathname,
            type: "POST",
            data: {"ajax": "check_request", "method": $("#method").val(), "account": $("#account").val(), "sum": $("sum").val()},
            success: function(data){
            	console.log(data);
                data = $.parseJSON(data);
                $("#response_result").val(data.answer);
                $("#request_url").val(data.url);
            }
        });
    });

    $("#send_wm_request").click(function(){

        $.ajax({
            url: location.pathname,
            type: "POST",
            data: {"ajax": "wm_request"},
            success: function(data){
            	console.log(data);
                data = $.parseJSON(data);
	            switch(data.status) {
	                case 'error':
	                  message(data.error, 'danger');
	                  $('button[type=submit]').prop('disabled', false);                                               
	                    break;
	                case 'success':
	                    message(data.success, 'success');
	                    $("#webmoney_request_modal").modal("hide");
	                    break;
	            }
            }
        });
    });

    $('#generalInfo, #otherInfo').ajaxForm({ 
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
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    }); 

    function changeURL(){
      $.ajax({
        url: location.pathname,
        type: "POST",
        data: {ajax: "checkURL", url: $("#shop_url").val()},
        success: function(data){
          data = $.parseJSON(data);
          switch(data.status) {
              case 'error':
                  $("#url_status").html('<div class="label label-danger"  data-toggle="tooltip" data-placement="top" title="Ошибка"><i class="fa fa-remove"></i></div>');                                              
                  break;
              case 'success':
                  $("#url_status").html('<div class="label label-success"  data-toggle="tooltip" data-placement="top" title="ОК"><i class="fa fa-check"></i></div>');
                  break;
          }
        }
      })
    }

    $("#new_public").click(function(){
        $.ajax({
          url: location.pathname,
          type: "POST",
          data: {ajax: "new_public"},
          success: function (data) {
            data = $.parseJSON(data);
            switch(data.status) {
                case 'error':
                  message(data.error, 'danger');
                  $('button[type=submit]').prop('disabled', false);                                               
                    break;
                case 'success':
                    message(data.success, 'success');
                    $("#shop_public_key").val(data.key);
                    break;
            }
          }
        })
    });

    $("#new_secret").click(function(){
        $.ajax({
          url: location.pathname,
          type: "POST",
          data: {ajax: "new_secret"},
          success: function (data) {
            data = $.parseJSON(data);
            switch(data.status) {
                case 'error':
                  message(data.error, 'danger');
                  $('button[type=submit]').prop('disabled', false);                                               
                    break;
                case 'success':
                    message(data.success, 'success');
                    $("#shop_secret_key").val(data.key);
                    break;
            }
          }
        })
    });

    $(document).ready(function(){
      changeURL();
    });
</script>
@stop