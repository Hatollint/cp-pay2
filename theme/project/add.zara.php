@extends("main")
@section("content")
<div class="container">
    <div class="card row col-sm-12" style="padding: 20px;">
        <form class="col-sm-6" method="POST" action="#" id="addShop" @if(!empty($shop)) style="display: none;" @endif >                       
            <div class="input-group">
                <span class="input-group-addon"><i class="md md-shopping-cart"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" name="shop_name" placeholder="Название проекта" onChange="changeDomain()">
                </div>
            </div>

            <br>
            
            <div class="input-group">
                <span class="input-group-addon"><i class="md md-devices"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" id="shop_domain" onChange="changeDomain()" name="shop_domain" placeholder="Домен, пример: localpay.ru" data-toggle="tooltip" data-placement="top" title="Вводить нужно без http://">
                </div>
            </div>

			<br>
            
            <div class="input-group">
                <span class="input-group-addon"><i class="md md-games"></i></span>
                <div class="fg-line">
               		<select class="form-control" name="shop_game">
                        <option value="0" disabled selected>Выберите категорию</option>
                        <option value="1">Интернет-магазин</option>
                        <option value="2">Игровой сервер</option>
                        <option value="3">Steam-проект</option>
                        <option value="4">Другое</option>
                  	</select>
               	</div>
            </div>

            <br>

            <div class="col-lg-12">
              	Убедитесь, что ваш сайт соответствует <a href="http://help.localpay.ru/article/rules" target="_blank">правилам</a>.<br><br>
            </div>

            <br>

            <div class="input-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <div class="fg-line">    
                        <input type="hidden" name="addShop" value="true">
                        <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Далее</button>
                    </div>
                </div>
            </div>
        </form>

        <form class="col-sm-6" method="POST" action="#" id="checkSite" @if(empty($shop)) style="display: none;" @endif >                       
			<div class="input-group" style="margin-top: 20px;">
                <div class="col-sm-12">
                    Для добавления сайта в наш сервис вам необходимо подтвердить что вы являетесь владельцом сайта. Для этого разместите у вас на сайте файл <span id="fileName" class="label label-info">{{ $file }}.txt</span> и внутри
		            него разметите следующий код:<br><br>
		            	<input type="text" class="form-control" id="codeCheck" name="codeCheck" value="{{ $code }}" disabled> 
		            	<input type="hidden" class="form-control" id="shopIDNew" name="shopIDNew" value="{{ $shop['shop_id'] }}"> 
                </div>
            </div>

            <br>

            <div class="input-group">
                <div class="col-sm-6 col-sm-offset-6">
                    <div class="fg-line">    
                        <input type="hidden" name="checkSite" value="true">
                        <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Добавить</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="col-lg-6">
          <img src="http://mini.s-shot.ru/?http://localpay.ru" id="siteScreen" style="width: 100%; border: 1px solid #ccc;">
        </div>
    </div>
</div>

<script>
	function changeDomain(){
      $("#siteScreen").attr("src","http://mini.s-shot.ru/?http://" + $("#shop_domain").val());
    }

    $('#addShop').ajaxForm({ 
        url: "/project/add",
        dataType: 'text',
        success: function(data) {
            data = $.parseJSON(data);
            switch(data.status) {
                case 'error':
                  message(data.error, 'danger');
                  $('button[type=submit]').prop('disabled', false);                                               
                    break;
                case 'success':
	                    $("#checkSite").show();
	                    $("#addShop").hide();
	                    $("#codeCheck").val(data.code);
	                    $("#shopIDNew").val(data.shopid);
	                    $("#fileName").html(data.file);
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    });

    $('#checkSite').ajaxForm({ 
        url: "/project/add",
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
	              	window.history.pushState(null, null, "/project/" + data.id);
	              	ajax_url("/project/" + data.id);
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    });
</script>
@stop