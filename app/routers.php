<?php
/*
|--------------------------------------------------------------------------
| Маршрутизация
|--------------------------------------------------------------------------
|
| Укажите пути маршрутизации и какие контроллеры будут выполняться вместе
| с их параметрами и так же действиями которые они должны выполнять
|
*/

return [
	['url' => '', 'as' => 'welcome',  'uses' => "HomeController@welcome"],

	// User
	['url' => 'login', 'as' => 'user.login',  'uses' => "UserController@login"],
	['url' => 'logout', 'as' => 'user.logout',  'uses' => "UserController@logout"],
	['url' => 'reg', 'as' => 'user.reg',  'uses' => "UserController@reg"],
	['url' => 'restore', 'as' => 'user.restore',  'uses' => "UserController@restore"],
	['url' => 'restore/{code:[a-zA-z0-9]+}', 'as' => 'user.restore',  'uses' => "UserController@restore"],
	['url' => 'auth/vk', 'as' => 'user.vk',  'uses' => "UserController@vk"],
	['url' => 'profile', 'as' => 'user.profile',  'uses' => "UserController@profile"],
	['url' => 'money', 'as' => 'user.money',  'uses' => "UserController@money"],
	['url' => 'confirm/{code:[a-zA-z0-9]+}', 'as' => 'user.confirm',  'uses' => "UserController@confirm"],

	// Projects
	['url' => 'project', 'as' => 'project.my',  'uses' => "ProjectController@my"],
	['url' => 'project/add', 'as' => 'project.add',  'uses' => "ProjectController@addProject"],
	['url' => 'project/add/{id:[0-9]+}', 'as' => 'project.add',  'uses' => "ProjectController@addProject"],
	['url' => 'project/{id:[0-9]+}', 'as' => 'project.view',  'uses' => "ProjectController@view"],

	//Support
	['url' => 'support', 'as' => 'support.list', 'uses' => 'SupportController@index'],
	['url' => 'support/notifications', 'as' => 'support.notifications', 'uses' => 'SupportController@notifications'],
	['url' => 'support/ticket-{id:[0-9]+}', 'as' => 'support.view', 'uses' => 'SupportController@view'],
	['url' => 'support/new', 'as' => 'support.new', 'uses' => 'SupportController@newticket'],
];