<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LocalPay | Восстановление пароля</title>

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
            <h1>LocalPay | Восстановление пароля</h1>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                Добрый день, на вашу почту было запрошено восстановление пароля.
                <br><br>
                Ваша ссылка для восстановления пароля:<br>
                <a href="https://cp.localpay.ru/restore/{{ $code }}">https://cp.localpay.ru/restore/{{ $code }}</a>
                <br><br>
            </div>
        </div>
        <blockquote><small>Если вы не восстанавливали пароль в панели управления, просто проигнорируйте это письмо.</small></blockquote>
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