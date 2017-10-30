@extends("main")
@section("content")
<div class="container">
    <div class="card">
        
        <div class="card m-b-0" id="messages-main">
            
            <div class="ms-menu" style="overflow: auto;">
                <div class="ms-block">
                    <div class="dropdown" data-animation="flipInX,flipOutX">
                        <a class="btn btn-primary btn-block waves-effect waves-button" href="#" data-toggle="dropdown"><span id="sort-now">Открытые</span> <i class="caret m-l-5"></i></a>

                        <ul class="dropdown-menu dm-icon w-100">
                            <li class="sort active" sort-type="opened" sort-text="Открытые"><a href="#"><i class="md md-lock-open"></i> <span>Открытые</span></a></li>
                            <li class="sort" sort-type="closed" sort-text="Закрытые"><a href="#"><i class="md md-lock-outline"></i> <span>Закрытые</span></a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="listview lv-user m-t-20" id="ticketsList">
                    @foreach($tickets as $item)
                    <div class="lv-item media ticket" ticket-id="{{ $item['ticket_id'] }}">
                        @if($item['ticket_status'] >= 1 && $item['ticket_status'] != 3)
                        <div class="lv-avatar bgm-green pull-left"><i class="md md-lock-open"></i></div>
                        @elseif($item['ticket_status'] == 3)
                        <div class="lv-avatar bgm-blue pull-left" data-toggle="tooltip" data-placement="right" title="Ответ от агента поддержки"><i class="md md-timer-auto"></i></div>
                        @else
                        <div class="lv-avatar bgm-red pull-left"><i class="md md-lock-outline"></i></div>
                        @endif
                        <div class="media-body">
                            <div class="lv-title">{{ $item['ticket_name'] }}</div>
                            <div class="lv-small">Проект: @if(empty($item['shop_name'])) Не относиться @else {{ $item['shop_name'] }} @endif </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
            
            <div class="ms-body">
                <div class="listview lv-message" id="ticket_body" style="display: none"></div>
                <div class="listview lv-message bgm-white" id="ticket_empty" style="height: 500px;">
                    <div class="lv-body">
                        <form class="col-sm-12" method="POST" action="#" id="newTicket"> 
                            <br> 

                            <div class="input-group col-sm-offset-1 col-sm-9">
                                <span class="input-group-addon"><i class="md md-textsms"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" name="name" placeholder="Введите тему обращения">
                                </div>
                            </div>

                            <br>
                            
                            <div class="input-group col-sm-offset-1 col-sm-9">
                                <span class="input-group-addon"><i class="md md-shopping-cart"></i></span>
                                <div class="fg-line">
                                    <select class="form-control" data-live-search="true" name="shop">
                                        <option value="0" disabled selected>Проект к которому относиться</option>
                                        <option value="none">Не относиться</option>
                                        @foreach($shops as $item)
                                        <option value="{{ $item['shop_id'] }}">#{{ $item['shop_id'] }} - {{ $item['shop_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <br>

                            <div class="input-group col-sm-offset-1 col-sm-9">
                                <span class="input-group-addon"><i class="md md-work"></i></span>
                                <div class="fg-line">
                                    <select class="form-control" name="dep">
                                        <option value="0" selected disabled>Выберите отдел</option>
                                        <option value="1">Финансовый</option>
                                        <option value="2">Консультационный</option>
                                        <option value="3">Технический</option>
                                    </select>
                                </div>
                            </div>

                            <br><br>

                            <div class="input-group col-sm-offset-1 col-sm-9">
                                <div class="fg-line">
                                   <textarea name="text" class="form-control" rows="4" placeholder="Введите текст обращения..."></textarea>
                                </div>
                            </div>

                            <br>

                            <div class="input-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <div class="fg-line">    
                                        <input type="hidden" name="newTicket" value="true">
                                        <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Создать запрос</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '.ticket', function(){
        $('#loading-page').css('display', 'block');
        window.history.pushState(null, null, "/support/ticket-" + $(this).attr("ticket-id"));
        $.ajax({
            url: "/support/ticket-" + $(this).attr("ticket-id"),
            type: "POST",
            data: 'ajax=getTicket',
            dataType: "html",
            success: function(data){
                $("html,body").scrollTop($("html,body").scrollTop());
                $("#ticket_body").html(data);
                $("#ticket_body").css('display', 'block');
                $("#ticket_empty").css('display', 'none');
                $('#loading-page').css('display', 'none');
            },
            error: function(){
                message("При загрузке страницы произошла ошибка!", "danger");
            }
        });
    });

    $(".sort").click(function(){
        $(".sort").removeClass("active");
        $(this).addClass("active");
        $("#sort-now").html($(this).attr("sort-text"));
        $.ajax({
            url: "/support",
            type: "POST",
            data: 'ajax=getTickets&sort='+$(this).attr("sort-type"),
            dataType: "html",
            success: function(data){
                $("#ticketsList").html(data);
            },
            error: function(){
                message("При загрузке страницы произошла ошибка!", "danger");
            }
        });
    });

    $('body').on('click', '#closeTicket', function(){
        $.ajax({
            
            url: location.pathname,
            type: "POST",
            data: {ajax: "closeticket"},
            success: function (data) {
                console.log(data);
                $('.lv-footer').hide();
                $('#closeTicket').hide();

                $.ajax({
                    url: "/support",
                    type: "POST",
                    data: 'ajax=getTickets&sort=closed',
                    dataType: "html",
                    success: function(data){
                        $("#ticketsList").html(data);
                    },
                    error: function(){
                        message("При загрузке страницы произошла ошибка!", "danger");
                    }
                });
            }
        });
    });

    function refreshmessagess(){
        $.ajax({ 
            
            url: location.pathname,
            type: "POST",
            data: {ajax: "getMessagess",},
            success: function (data) {
                $("#ticket_body").html(data);
            }
        })
    }


    function sendAnswer() {

        if ($("#text").val() == "") {
            message('Введите сообщение для ответа!', "danger");
        } else { 
            $.ajax({
                url: location.pathname,
                type: "POST",
                data: {ajax: "addmessage", text: $("#text").val()},
                success: function (data) {
                    console.log(data);
                    data = $.parseJSON(data);
                    switch(data.status) {
                        case 'error':
                          message(data.error, 'danger');
                          $('button[type=submit]').prop('disabled', false);                                               
                            break;
                        case 'success':
                            message(data.success, 'success');
                            refreshmessagess();
                            break;
                    }
                }
            });
        }
    };

    $('#newTicket').ajaxForm({ 
        url: location.pathname,
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
                    window.history.pushState(null, null, "/support/ticket-" + data.id);
                    ajax_url("/support/ticket-" + data.id);
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    }); 
</script>
@stop