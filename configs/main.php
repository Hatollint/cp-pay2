<?php
/*
|--------------------------------------------------------------------------
| Главный файл конфигурации
|--------------------------------------------------------------------------
|
| Указаны основые данны для работы с системой
| Есть возможность подключить сторонние конфигурационные файлы
|
*/
return [

	// Режим откладки, рекомендуеться использовать во время разработки
	'debug_mode'	=>		false,

	// URL вашего сайта.
	// Будет использовано при формировании URL адреса
	'url'			=>		'http://example.com/',
	
	// Токен.
	// Используется для запуска скриптов из Cron`а.
	'token'			=>		'mytoken123',
	
	// Данные Базы Данных
	'db'			=>		[
		
		// Драйвер для работы с БД.
		// По умолчанию MySQL (mysqli).
		'driver'		=>		'mysql',

		// Тип СУБД.
		// По умолчанию поддерживается только СУБД MySQL (mysql).
		'type'			=>		'mysql',
		
		// Хост БД.
		// Пример: localhost, 127.0.0.1, db.example.com и пр.
		'hostname'		=>		'localhost',
		
		// Имя пользователя СУБД.
		'username'		=>		'u0218813_default',
		
		// Пароль пользователя СУБД.
		'password'		=>		'i!C0a8_H',
		
		// Название БД.
		'database'		=>		'u0218813_default',

		// Испльзуемая кодировка
		'charset'   	=> 		'utf8',
		
	],
	
	
	// Настройки почты
	'mail' 		=> 		[
		
		// E-Mail отправителя.
		// Пример: support@example.com, noreply@example.com
		'mail_from'		=>		'support@example.com',
		
		// Имя отправителя.
		// Пример: Ivan Petrov
		'mail_sender'		=>		'Ivan Petrov',

		'smtp' 			=> 	[

			'smtp_host'			=>	'server99.hosting.reg.ru',
			'smtp_username'		=>	'support@localpay.ru',
			'smtp_password'		=>	'x6xXIb0c',
			'smtp_port'			=>	'465',
			'smtp_from'			=>	'support@localpay.ru',
			
		],
	],
	
];