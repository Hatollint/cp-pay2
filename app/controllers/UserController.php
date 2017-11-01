<?php
/*
* MyUCP
*/

class UserController extends Controller {

	public function welcome() {

		if(empty($this->session->data['user_id']))
			return view("login");

		return view("welcome", ['ajax' => false]);
	}

	public function profile() {
		if(empty($this->session->data['user_id']))
			return view("login");

		model("User", "Log");
		$userid = $this->session->data['user_id'];

		$this->data['user'] = $this->UserModel->getUser($userid);

		if($this->request->post['generalInfo']){

			$firstname = $this->request->post['firstname'];
			$lastname = $this->request->post['lastname'];
			$email = $this->request->post['email'];

			if(!empty($firstname) && !empty($lastname) && !empty($lastname)){
				if($email != $this->data['user']['user_email']){
					if(preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email)){
						if(!$this->UserModel->getUser($email, "user_email")){
							$this->UserModel->set(['user_email' => $email, 'user_firstname' => $firstname, 'user_lastname' => $lastname])->where("user_id", "=", $userid)->update();
							$this->LogModel->pushLog("Изменение главных данных пользователя", $this->router->route());
							$result = ['status' => 'success', 'success' => "Данные успешно изменены!"];
						} else {
							$result = ['status' => 'error', 'error' => "Указанный вами Email адресс уже занят!"];
							return json_encode($result);
						}
					} else {
						$result = ['status' => 'error', 'error' => "Указанный вами Email адресс некорректный!"];
						return json_encode($result);
					}
				} else {
					$this->UserModel->set(['user_firstname' => $firstname, 'user_lastname' => $lastname])->where("user_id", "=", $userid)->update();
					$result = ['status' => 'success', 'success' => "Данные успешно изменены!"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Все поля обязательны к заполнению!"];
			}

			return json_encode($result);
		}

		if($this->request->post['vk']){

			$vkid = $this->request->post['response']['session']['user']['id'];

			if($u = $this->UserModel->getUser($vkid, "user_vk_id")){
				$result = ['status' => 'error', 'error' => "Данный профиль ВКонтакте уже привязан к другому аккаунту!"];
			} else {
				$result = ['status' => 'success', 'success' => "Профиль ВКонтакте был привязан!"];
				$this->UserModel->set(['user_vk_id' => $vkid])->where("user_id", "=", $userid)->update();
			}
			$this->LogModel->pushLog("Привязка профиля VK", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['unsetvk']){

			if(empty($this->data['user']['user_vk_id'])) {
				$result = ['status' => 'error', 'error' => "Профиль ВКонтакте не привязан!"];
			} else {
				$result = ['status' => 'success', 'success' => "Профиль ВКонтакте был отвязан!"];
				$this->UserModel->set(['user_vk_id' => ""])->where("user_id", "=", $userid)->update();
			}
			$this->LogModel->pushLog("Отвязка профиля VK", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['moneyInfo']){

			$wm = $this->request->post['wm'];
			$qiwi = $this->request->post['qiwi'];

			if(strpos($wm, "R") === false && !empty($wm)){
				$result = ['status' => 'error', 'error' => "Кошелек WebMoney введен неверно!"];
				return json_encode($result);
			}

			if(strpos($qiwi, "+") === false && !empty($qiwi)){
				$result = ['status' => 'error', 'error' => "Кошелек Qiwi введен неверно!"];
				return json_encode($result);
			}

			$this->UserModel->set(['user_wmr' => $wm, 'user_qiwi' => $qiwi])->where("user_id", "=", $userid)->update();
			//$this->UserModel->addSecureRequest("2", $userid, [$wm, $qiwi]);
			$result = ['status' => 'success', 'success' => "Данные успешно изменены!"];
			//$result = ['status' => 'success', 'success' => "Подтвердите ваши действия, на вашу почту отправленна ссылка подтверждения!"];
			$this->LogModel->pushLog("Изменение кошельков", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['securityInfo']){

			$password = $this->request->post['password'];
			$newpassword = $this->request->post['newpassword'];
			$newpasswordsecond = $this->request->post['newpasswordsecond'];

			if(md5($password."maksa988key") == $this->data['user']['user_password']){
				if($password == $newpassword){
					$result = ['status' => 'error', 'error' => "Новый пароль должен отличаться от старого!"];
				} else {
					if($newpassword == $newpasswordsecond){
						$newpassword = md5($newpassword."maksa988key");
						// $this->UserModel->set(['user_password' => $newpassword])->where("user_id", "=", $userid)->update();
						$this->UserModel->addSecureRequest("1", $userid, $newpassword);
						$result = ['status' => 'success', 'success' => "Подтвердите ваши действия, на вашу почту отправленна ссылка подтверждения!"];
					} else {
						$result = ['status' => 'error', 'error' => "Пароли не совпадают!"];
					}
				}
			} else {
				$result = ['status' => 'error', 'error' => "Текущий пароль введен неверно!"];
			}
			$this->LogModel->pushLog("Изменение пароля", $this->router->route());
			return json_encode($result);
		}
		if($this->request->files['avatar']){

			$img = $this->request->files['avatar'];
			if(strpos($img['type'], "image") === false){
				$result = ['status' => 'error', 'error' => "Для загрузки вы должны выбрать изображение!"];
			} else {
				$name = "/assets/users/avatars/".md5($img['name'].time()).".jpg";
				if(!copy($img['tmp_name'], ".".$name)){
					$result = ['status' => 'error', 'error' => "При загрузке изображения произошла ошибка!"];
				} else {
					$this->UserModel->set(['user_avatar' => $name])->where("user_id", "=", $userid)->update();
					$result = ['status' => 'success', 'success' => "Ваш аватар успешно изменен!", "avatar" => $name];
				}
			}
			$this->LogModel->pushLog("Смена аватарки", $this->router->route());
			return json_encode($result);
		}

		return view("user/profile", $this->data);
	}

	public function login(){

		if(!empty($this->session->data['user_id']))
			$this->response->redirect("/");

		model("User", "Log");

		if($this->request->post['auth']){
			$login = $this->request->post['login'];
			$password = $this->request->post['password'];
			$remember = $this->request->post['remember'];

			if(!empty($login) && !empty($password)){
				if($user = $this->UserModel->getUser($login, "user_login")){
					if(md5($password."maksa988key") == $user['user_password']){
						if(!empty($remember)){
							$token = md5($login.$user['user_id'].time()."maksa988");
							setcookie("__token", $token, time()+60*60*24*30);
							$this->UserModel->set(['user_token' => $token])
											->where("user_id", '=', $user['user_id'])
											->update();
						}
						$this->UserModel->set(['user_login_time' => 'NOW()', 'user_login_ip' => $this->request->server['REMOTE_ADDR']])
										->where("user_id", '=', $user['user_id'])
										->update();
						$this->session->data['user_id'] = $user['user_id'];
						$this->LogModel->pushLog("Успешная авторизация", $this->router->route());
						$result = ['status' => 'success'];
					} else {
						$this->LogModel->pushLog("Ошибка авторизации [0]", $this->router->route());
						$result = ['status' => 'error', 'error' => "Логин или пароль введены неверно!"];
					}
				} else {
					$this->LogModel->pushLog("Ошибка авторизации [1]", $this->router->route());
					$result = ['status' => 'error', 'error' => "Логин или пароль введены неверно!"];
				}
			} else {
				$this->LogModel->pushLog("Ошибка авторизации [2]", $this->router->route());
				$result = ['status' => 'error', 'error' => "Все поля обязательны к заполнению!"];
			}

			return json_encode($result);
		}

		return view("login");
	}

	public function reg(){

		if(!empty($this->session->data['user_id']))
			$this->response->redirect("/");

		model("User", "Log");

		if($this->request->post['reg']){
			$login = $this->request->post['login'];
			$password = $this->request->post['password'];
			$email = $this->request->post['email'];
			$firstname = $this->request->post['firstname'];
			$lastname = $this->request->post['lastname'];
			$agreement = $this->request->post['agreement'];

			if(!empty($login)){	
				if(preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email)){
					if(preg_match("/^[a-zA-Z0-9,\.!?_-]{6,32}$/", $password)){
						if(!$user = $this->UserModel->getUser($login, "user_login")){
							if(!$this->UserModel->getUser($email, "user_email")){
								if(!empty($firstname) && !empty($firstname)){
									if(!empty($agreement)){
										$data = [
											'user_login' => $login,
											'user_email' =>	$email,
											'user_password' => 	md5($password."maksa988key"),
											'user_reg_time'	=> 	'NOW()',
											'user_reg_ip'	=>	$this->request->server['REMOTE_ADDR'],
											'user_firstname'=>	$firstname,
											'user_lastname'	=>	$lastname
										];
										$this->UserModel->create($data);
										$this->LogModel->pushLog("Успешная регистрация", $this->router->route());
										$result = ['status' => 'success', 'success' => "Вы успешно зарегестрированы!"];
									} else {
										$this->LogModel->pushLog("Ошибка регистрации [0]", $this->router->route());
										$result = ['status' => 'error', 'error' => "Вы не согласились с пользовательским соглашением!"];
									}
								} else {
									$this->LogModel->pushLog("Ошибка регистрации [1]", $this->router->route());
									$result = ['status' => 'error', 'error' => "Все поля обязательны к заполнению!"];
								}
							} else {
								$this->LogModel->pushLog("Ошибка регистрации [2]", $this->router->route());
								$result = ['status' => 'error', 'error' => "Введеный вами Email адрес занят!"];
							}
						} else {
							$this->LogModel->pushLog("Ошибка регистрации [3]", $this->router->route());
							$result = ['status' => 'error', 'error' => "Введеный вами логин занят!"];
						}
					} else {
						$this->LogModel->pushLog("Ошибка регистрации [4]", $this->router->route());
						$result = ['status' => 'error', 'error' => "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!"];
					}
				} else {
					$this->LogModel->pushLog("Ошибка регистрации [5]", $this->router->route());
					$result = ['status' => 'error', 'error' => "Указанный вами Email адресс некорректный!"];
				}
			} else {
				$this->LogModel->pushLog("Ошибка регистрации [6]", $this->router->route());
				$result = ['status' => 'error', 'error' => "Логин должен содержать от 6 до 15 латинских букв и цифр!"];
			}

			return json_encode($result);
		}

		return view("login");
	}

	public function restore($code = null) {

		if(!empty($this->session->data['user_id']))
			$this->response->redirect("/");

		model("User", "Log");

		if($this->request->post['restore']) {

			$email = $this->request->post['email'];

			if(!empty($email)) {
				if($user = $this->UserModel->getUser($email, "user_email")) {
					$code = md5(time()."maksa988");
					$this->UserModel->set(['user_restore_code' => $code])->where("user_id", "=", $user['user_id'])->update();
					$this->UserModel->sendRestore($email, $code);
					$this->LogModel->pushLog("Восстановление пароля [Отправленно на почту]", $this->router->route());
					$result = ['status' => 'success', 'success' => "На вашу почту отправленна ссылка для восстановления пароля!"];
				} else {
					$this->LogModel->pushLog("Ошибка восстановления пароля [0]", $this->router->route());
					$result = ['status' => 'error', 'error' => "Email адрес указанный Вами не найден в системе!"];
				}
			} else {
				$this->LogModel->pushLog("Ошибка восстановления пароля [1]", $this->router->route());
				$result = ['status' => 'error', 'error' => "Введите Email адрес!"];
			}

			return json_encode($result);
		}

		if($code) {

			if($user = $this->UserModel->getUser($code, "user_restore_code")) {
				if($this->request->post['confirm']) {

					$newpassword = $this->request->post['newpassword'];
					$newpasswordsecond = $this->request->post['newpasswordsecond'];

					if(!empty($newpassword) && !empty($newpasswordsecond)) {
						if($newpassword == $newpasswordsecond) {
							if(preg_match("/^[a-zA-Z0-9,\.!?_-]{6,32}$/", $newpassword)) {
								$newpassword = md5($newpassword."maksa988key");
								$this->UserModel->set(['user_restore_code' => "", "user_password" => $newpassword])->where("user_id", "=", $user['user_id'])->update();
								$this->LogModel->pushLog("Успешно восстановлен пароль", $this->router->route());
								$result = ['status' => 'success', 'success' => "Вы успешно изменили пароль!"];
							} else {
								$this->LogModel->pushLog("Ошибка подтверждения восстановления пароля [0]", $this->router->route());
								$result = ['status' => 'error', 'error' => "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!"];
							}
						} else {
							$this->LogModel->pushLog("Ошибка подтверждения восстановления пароля [1]", $this->router->route());
							$result = ['status' => 'error', 'error' => "Пароли не совпадают!"];
						}
					} else {
						$this->LogModel->pushLog("Ошибка подтверждения восстановления пароля [2]", $this->router->route());
						$result = ['status' => 'error', 'error' => "Все поля обязательны к заполнению!"];
					}

					return json_encode($result);
				}
			} else {
				$this->LogModel->pushLog("Ошибка подтверждения восстановления пароля [3]", $this->router->route());
				$this->data['error'] = "Данная ссылка восстановления пароля недействительна!";
			}

			return view("user/restore", $this->data);
		} else {
			return view("login");
		}
	}

	public function confirm($code) {
		model("User", "Log");

		if($this->UserModel->confirmSecureRequest($code)) {
			echo "<script>location.href = '/profile#sec_success'</script>";
		} else {
			echo "<script>location.href = '/profile#sec_error'</script>";
		}
		$this->LogModel->pushLog("Подтверждение изменения данных", $this->router->route());
	}

	public function logout() {
		model("User", "Log");

		$this->UserModel->set(['user_token' => ""])->where("user_id", '=', $this->session->data['user_id'])->update();
		$this->LogModel->pushLog("Выход из профиля", $this->router->route());
		unset($this->session->data['user_id']);
		return "<script>location.href = '/'</script>";
	}

	public function money(){
		if(empty($this->session->data['user_id']))
			return view("login");

		model("User", "Log");

		if($this->request->post['cancelPay']){
			$id = (int) $this->request->post['id'];

			$user = $this->UserModel->getUser($this->session->data['user_id']);

			$this->UserModel->table("gd_money_back");
			$m = $this->UserModel->where("money_id", "=", $id)->get();

			if($user['user_id'] == $m['user_id']) {
				if($m['money_status'] != 1 && $m['money_status'] != 2){
					$this->UserModel->set(['user' => $this->session->data['user_id'], 'money_status' => 1])->where("money_id", "=", $id)->update();

					$this->UserModel->table("gd_users");
					$this->UserModel->set(['user_balance' => ($user['user_balance'] + $m['money_sum'])])
									->where('user_id', '=', $this->session->data['user_id'])
									->update();
					$this->LogModel->pushLog("Отмена запроса на вывод средств", $this->router->route());
					$result = ['status' => 'success', 'success' => 'Запрос на вывод средств #'.$id.' успешно отменен!'];
				} else {
					$result = ['status' => 'error', 'error' => 'Запрос на вывод средств уже отменен или выполнен!'];
				}
			} else {
				$this->LogModel->pushLog("Попытка отменить не свой вывод", $this->router->route());
				$result = ['status' => 'error', 'error' => 'При отмене вывода средств произошла ошибка!'];
			}

			return json_encode($result);
		}	

		if($this->request->post['pay_money']){

			$pay_sum = (int) $this->request->post['pay_sum'];
			$pay_system = $this->request->post['pay_system'];
			$user = $this->UserModel->getUser($this->session->data['user_id']);

			if(!empty($pay_sum)){
				if(!empty($pay_system)){
					if($user['user_balance'] >= $pay_sum){
						if($pay_sum <= "14999") {
							if($pay_sum >= 50){
								$percent = 0.10;
								$percent = $pay_sum * $percent;
								$pay_sum = $pay_sum - $percent;


								$key = md5(md5(md5(time().$sum)."maksa988"));
								$key = $key{1}.$key{2}.$key{3}.$key{4}.$key{5}.$key{6}.$key{7}.$key{8};

								$data = [
									'user_id' 		=> 	$this->session->data['user_id'],
									'money_key'		=>	$key,
									'money_sum'		=>	(int) $pay_sum,
									'money_time'	=>	'NOW()',
									'money_system'	=>	(int) $pay_system,
								];

								$this->UserModel->table("gd_money_back");
								if($this->UserModel->create($data)){
									$this->UserModel->table("gd_users");
									$this->UserModel->set(['user_balance' => ($user['user_balance'] - $this->request->post['pay_sum'])])
													->where('user_id', '=', $this->session->data['user_id'])
													->update();
									$this->LogModel->pushLog("Новый запрос на вывод средств", $this->router->route());
									$result = ['status' => 'success', 'success' => 'Запрос на вывод стредств был создан!'];
								} else {
									$result = ['status' => 'error', 'error' => 'При создании запроса произошла ошибка. Повторите попытку позже!'];
								}
							} else {
								$result = ['status' => 'error', 'error' => 'Минимальная сумма вывода <b>50</b> руб.'];
								return json_encode($result);
							}
						} else {
							$result = ['status' => 'error', 'error' => 'Максимальная сумма вывода 14999 руб.'];
						}
					} else {
						$result = ['status' => 'error', 'error' => 'На вашем балансе недостаточно денег для вывода!'];
					}
				} else {
					$result = ['status' => 'error', 'error' => 'Выберите платежную систему!'];
				}
			} else {
				$result = ['status' => 'error', 'error' => 'Введите сумму для вывода средств!'];
			}
			$this->LogModel->pushLog("Попытка запроса вывода средств", $this->router->route());
			return json_encode($result);
		}

		$this->UserModel->table("gd_money_back");
		$this->data['moneys'] = $this->UserModel->where("user_id", "=", $this->session->data['user_id'])->order("money_id", "desc")->get("all");

		return view("user/money", $this->data);
	}

	public function vk() {
		if(!empty($this->session->data['user_id']))
			return view("errors/404");

		model("User", "Log");

		if($this->request->post['auth']){
			$id = $this->request->post['response']['session']['user']['id'];

			if($u = $this->UserModel->getUser($id, "user_vk_id")){
				$this->session->data['user_id'] = $u['user_id'];
				$result = ['status' => 'auth'];
			} else {
				$this->session->data['auth_vk'] = $id;
				$result = ['status' => 'success'];
			}
			$this->LogModel->pushLog("Авторизация через VK", $this->router->route());
			return json_encode($result);
		}

		if(!empty($this->session->data['auth_vk'])) {
			if($user = @file_get_contents("https://api.vk.com/method/users.get?uids={$this->session->data['auth_vk']}&fields=uid,first_name,last_name,screen_name,sex,bdate,photo_big"))
				$this->data['user'] = json_decode($user, true);

			$email = $this->request->post['email'];
			$password = $this->request->post['password'];
			$agreement = $this->request->post['agreement'];

			if($this->request->post['reg']) {
				if(preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $email)){
					if(preg_match("/^[a-zA-Z0-9,\.!?_-]{6,32}$/", $password)){
						if(!$this->UserModel->getUser($email, "user_email")){
							if(!empty($agreement)){
								$data = [
									'user_login' => $this->data['user']['response'][0]['screen_name'],
									'user_email' =>	$email,
									'user_password' => 	md5($password."maksa988key"),
									'user_reg_time'	=> 	'NOW()',
									'user_reg_ip'	=>	$this->request->server['REMOTE_ADDR'],
									'user_firstname'=>	$this->data['user']['response'][0]['first_name'],
									'user_lastname'	=>	$this->data['user']['response'][0]['last_name'],
									'user_vk_id'	=> $this->session->data['auth_vk'],
									'user_avatar'	=> $this->data['user']['response'][0]['photo_big'],
								];

								$uid = $this->UserModel->create($data);
								$this->session->data['user_id'] = $uid;
								unset($this->session->data['auth_vk']);
								$this->LogModel->pushLog("Регистрация через VK", $this->router->route());
								$result = ['status' => 'success', 'success' => "Вы успешно зарегестрированы!"];
							} else {
								$result = ['status' => 'error', 'error' => "Вы не согласились с пользовательским соглашением!"];
							}
						} else {
							$result = ['status' => 'error', 'error' => "Введеный вами Email адрес занят!"];
						}
					} else {
						$result = ['status' => 'error', 'error' => "Пароль должен содержать от 6 до 32 латинских букв, цифр и знаков <i>,.!?_-</i>!"];
					}
				} else {
					$result = ['status' => 'error', 'error' => "Указанный вами Email адресс некорректный!"];
				}
				$this->LogModel->pushLog("Попытка регистрации через VK", $this->router->route());
				return json_encode($result);
			}

			return view("user/vk", $this->data);
		} else {
			return view("login");
		}
	}
}