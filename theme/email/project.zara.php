<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if($status == 1)
    <title>LocalPay | Одобрение проекта</title>
    @else
    <title>LocalPay | Проект заблокирован</title>
    @endif

    <link href="http://api.localpay.ru/style/bootstrap.min.css" rel="stylesheet">
    <link href="http://api.localpay.ru/style/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="http://api.localpay.ru/style/sticky-footer.css" rel="stylesheet">
    <style>
        a.paysystem {
            display: inline-block;
            width: 23%;
            margin: 0px 15px;
            cursor: pointer;
        }

        .clear {
            clear: both;
        }
    </style>
  </head>

  <body>

    <div class="container">
        <div class="page-header">
            @if($status == 1)
            <h1>LocalPay | Одобрение проекта</h1>
            @else
            <h1>LocalPay | Проект заблокирован</h1>
            @endif
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                @if($status == 1)
                Ваш проект был одобрен и вы можете пользоваться всеми функциями сервиса.<br>
                Если вам нужна помощь вы можете найти некоторые ответы в нашем <a href="https://help.localpay.ru/">центре помощи</a>, если вы не найдете ответ вы можете обратиться в нашу <a href="https://cp.localpay.ru/support">поддержку</a>.
                @else
                Ваш проект был проверен нашими модераторами и был отклонен в связи с несоотвествием правил.<br>
                Сообщение от модератора: <b>{{ $message }}</b>
                @endif
            </div>
        </div>
        <blockquote>
            <small>Просим не отвечать на данное сообщение, оно было сгенерировано и отправлено автоматически.</small>
        </blockquote>
    </div>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">
            <a href="http://cp.localpay.ru/support" class="text-left">Поддержка</a> | <a href="http://help.localpay.ru/" class="text-left">Центр помощи</a>
            <span class="pull-right">| <a href="http://localpay.ru/">LocalPay</a> &copy; 2016</span>
        </p>
        <div class="clear"></div>
      </div>
    </footer>
  </body>
</html>