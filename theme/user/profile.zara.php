@extends("main")
@section("content")
<div class="container">
    <div class="card" id="profile-main">
        <div class="pm-overview c-overflow" tabindex="8" style="overflow: hidden; outline: none;">
            <div class="pmo-pic">
                <div class="p-relative">
                    <a href="#">
                        <img class="img-responsive" src="{{ $user['user_avatar'] }}" alt="" id="Avatar"> 
                        <form class="fileinput fileinput-new" method="POST" action="#" data-provides="fileinput" id="changeAvatarForm" style="display:none; width: 100%;" enctype="multipart/form-data">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%; height: 300px;"></div>
                            <div>
                                <span class="btn-file">
                                    <span class="btn btn-info fileinput-new">Выбрать изображение</span>
                                    <span class="btn btn-info fileinput-exists">Выбрать другое</span>
                                    <input type="file" name="avatar">
                                </span>
                                <button class="btn btn-primary btn-sm hec-button waves-effect waves-button fileinput-exists" name="changeAvatar" value="true">Сохранить</button>
                            </div>
                        </form>
                    </a>
                    <a href="#" class="pmop-edit" id="changeAvatar">
                        <i class="md md-photo-camera"></i> <span class="hidden-xs">Загрузить новую аватарку</span>
                    </a>                                  
                </div>
            </div>                        
        </div>
        
        <div class="pm-body clearfix">
            <div role="tabpanel" class="tab">
                <ul class="tab-nav" role="tablist" tabindex="3" style="overflow: hidden; outline: none;">
                    <li class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true">Основная информация</a></li>
                    <li role="presentation" class=""><a href="#money" aria-controls="money" role="tab" data-toggle="tab" aria-expanded="false">Кошельки</a></li>
                    <li role="presentation" class=""><a href="#security" aria-controls="security" role="tab" data-toggle="tab" aria-expanded="false">Безопасность</a></li>
                </ul>
              
                <div class="tab-content col-sm-12 pmb-block">
                    <div role="tabpanel" class="tab-pane animated fadeInUp active" id="general">
                        <form class="col-sm-12" method="POST" action="#" id="generalInfo">                       
                            <div class="input-group">
                                <span class="input-group-addon"><i class="md md-person"></i></span>
                                <div class="col-sm-6">
                                    <div class="fg-line">    
                                        <input type="text" class="form-control" name="firstname" placeholder="Имя" value="{{ $user['user_firstname'] }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="fg-line">    
                                        <input type="text" class="form-control" name="lastname" placeholder="Фамилия"  value="{{ $user['user_lastname'] }}">
                                    </div>
                                </div>
                            </div>

                            <br>
                            
                            <div class="input-group">
                                <span class="input-group-addon"><i class="md md-email"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" name="email" placeholder="Email адрес" value="{{ $user['user_email'] }}">
                                </div>
                            </div>
                            
                            <br>
                            
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-vk fa-2x"></i></span>
                                <div class="fg-line">
                                    @if(empty($user['user_vk_id']))
                                        <a href="#" onclick="VK.Auth.login(authInfo); return false;" class="btn btn-xs btn-info">Привязать</a>
                                    @else
                                        <a href="#" onclick="unsetVK(); return false;" class="btn btn-xs btn-success">Отвязать</a>
                                    @endif
                                </div>
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
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeInUp" id="money">
                        <form class="col-sm-12" method="POST" action="#" id="moneyInfo">                       
                            <div class="input-group">
                                <span class="input-group-addon"><img src="http://android4fun.org/media/images/1545.jpg" width="16" alt=""></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" name="wm" placeholder="WMR" value="{{ $user['user_wmr'] }}">
                                </div>
                            </div>

                            <br>
                            
                            <div class="input-group">
                                <span class="input-group-addon"><img src="http://penspinning.kz/pics/shop/icons/qiwi.ru.png" width="16" alt=""></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" name="qiwi" placeholder="Номер телефона" value="{{ $user['user_qiwi'] }}">
                                </div>
                            </div>

                            <br>

                            <div class="input-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <div class="fg-line">    
                                        <input type="hidden" name="moneyInfo" value="true">
                                        <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane animated fadeInUp" id="security">
                        <form class="col-sm-12" method="POST" action="#" id="securityInfo"> 

                            <div class="input-group">
                                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" placeholder="Текущий пароль" name="password" value="">
                                </div>
                            </div>
                            <br>

                            <div class="input-group">
                                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" placeholder="Новый пароль" name="newpassword" value="">
                                </div>
                            </div>

                            <br>
                            
                            <div class="input-group">
                                <span class="input-group-addon"><i class="md md-accessibility"></i></span>
                                <div class="fg-line">
                                    <input type="text" class="form-control" placeholder="Повторите новый пароль" name="newpasswordsecond" value="">
                                </div>
                            </div>

                            <br>

                            <div class="input-group">
                                <div class="col-sm-8 col-sm-offset-4">
                                    <div class="fg-line">    
                                        <input type="hidden" name="securityInfo" value="true">
                                        <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Сохранить</button>
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
<script>
    $('#generalInfo, #securityInfo, #moneyInfo').ajaxForm({ 
        url: '/profile',
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
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    }); 

    $('#generalInfo, #securityInfo, #changeAvatarForm').ajaxForm({ 
        url: '/profile',
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
                    $("#changeAvatar").show();
                    $("#changeAvatarForm").hide();
                    $("#Avatar").attr("src", data.avatar).show();
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    });

    $("#changeAvatar").click(function(){
        $(this).hide();
        $("#changeAvatarForm").show();
        $("#Avatar").hide();
    });

    if(location.hash == "#sec_success") {
        message("Данные успешно сохранены", 'success');
    }

    if(location.hash == "#sec_error") {
        message("При сохранении произошла ошибка", 'danger');
    }

    function unsetVK() {
        $.ajax({ 
            url: location.pathname,
            type: "POST",
            data: {unsetvk: true},
            success: function (data) {
                data = $.parseJSON(data);
                switch(data.status) {
                    case 'error':
                        message(data.error, 'danger');
                        $('button[type=submit]').prop('disabled', false);                                               
                        break;
                    case 'success':
                        message(data.success, 'success');
                        $('button[type=submit]').prop('disabled', false);  
                        ajax_url(location.pathname);
                        break;
                }
            }
        });
    }

    function authInfo(response) {
        if(response.session) {
            $.ajax({ 
                url: location.pathname,
                type: "POST",
                data: {vk: true, response: response},
                success: function (data) {
                    data = $.parseJSON(data);
                    switch(data.status) {
                        case 'error':
                            message(data.error, 'danger');
                            $('button[type=submit]').prop('disabled', false);                                               
                            break;
                        case 'success':
                            message(data.success, 'success');
                            $('button[type=submit]').prop('disabled', false);  
                            ajax_url(location.pathname);
                            break;
                    }
                }
            });
        }
    }
</script>
@stop