@extends("main")
@section("content")
<div class="container">
    <div class="card">
        
        <div class="card-body card-padding">
            <div class="row">
                <form class="col-sm-12" id="pay_money" method="POST" action="#">                       
                    <div class="input-group">
                        <span class="input-group-addon"><i class="md md-attach-money"></i></span>
                        <div class="col-sm-3">
                            <div class="fg-line">    
                                <input type="text" class="form-control" name="pay_sum" placeholder="Сумма для вывода">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="fg-line">    
                                <select class="selecstpicker" name="pay_system">
                                    <option value="0" selected disabled>Выберите платежную систему</option>
                                    <option value="1">WebMoney</option>
                                    <option value="2">Qiwi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="fg-line">    
                                <input type="hidden" name="pay_money" value="true">
                                <button class="btn btn-primary btn-sm hec-button waves-effect waves-button">Запросить выплату</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive" tabindex="0" style="overflow: hidden; outline: none;">
            <table id="data-table-command" class="table table-striped bootgrid-table" aria-busy="false">
                <thead>
                    <tr>
                        <th data-column-id="id" class="text-left" data-type="numeric">#</th>
                        <th data-column-id="code" class="text-left">Код</th>
                        <th data-column-id="time" class="text-left">Дата</th>
                        <th data-column-id="summ" class="text-left">Сумма</th>
                        <th data-column-id="status" data-formatter="status" class="text-left">Статус</th>
                        <th data-column-id="commands" data-formatter="commands" data-sortable="false"></th>
                    </tr>
                </thead>
                <tbody>
                	<?php $id = 0 ?>
                    @foreach($moneys as $item)
                    <?php $id++?>
                    <tr>
                        <td>{{ $item['money_id'] }}</td>
                        <td>{{ $item['money_key'] }}</td>
                        <td>{{ date("d.m.Y в H:i", strtotime($item['money_time'])) }}</td>
                        <td>{{ $item['money_sum'] }} руб.</td>
                        <td>{{ $item['money_status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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
                return "<button type=\"button\" class=\"btn btn-xs command-delete\" data-row-id=\"" + row.id + "\" onclick=\"cancelPay(" + row.id + ")\"><span class=\"md md-close\"></span></button>";
            },
            "status": function(column, row) {

                if(row.status == 0){
                    return '<span class="label label-warning">Ожидает выплаты</span>';
                } 
                if(row.status == 1){
                    return '<span class="label label-danger">Ошибка выплаты</span>';
                } 
                if(row.status >= 2){
                    return '<span class="label label-success">Выплачено</span>';
                } 

            }
        }
    });

    if({{ $id }} <= 10){
        $("#data-table-basic-command").remove();
    }
    $("#data-table-command-header").remove();
    $('.selecstpicker').selectpicker();

    $('#pay_money').ajaxForm({ 
        url: '/money',
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
                    ajax_url("/money");
                    break;
            }
        },
        beforeSubmit: function(arr, $form, options) {
            $('button[type=submit]').prop('disabled', true);
        }
    });

    function cancelPay(id){
        $.ajax({ 
            url: location.pathname,
            type: "POST",
            data: {cancelPay: true, id: id},
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
                        ajax_url("/money");
                        break;
                }
            }
        });
    }
</script>
@stop