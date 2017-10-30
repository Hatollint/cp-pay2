<?php
/*
* MyUCP
*/

class ProjectController extends Controller {

	public function view($id) {
		
		if(empty($this->session->data['user_id']))
			return view("login");

		model("Project", "User", "Stats", "Log");

		if($project = $this->ProjectModel->getProject($id)){
			if($project['user_id'] == $this->session->data['user_id']) {
				$this->data['project'] = $project;
			} else {
				return view("errors/404");
			}
		} else {
			return view("errors/404");
		}

		if($this->request->post['ajax'] == "new_secret") {
			$secret_key = md5(md5(md5(time().$project['shop_id'])."maksa988"));
			if($project['user_id'] == $this->session->data['user_id']) {
				if($this->ProjectModel->set(['shop_secret_key' => $secret_key])->where("shop_id", "=", $id)->update()){
					$this->LogModel->pushLog("Сгенерирован новый секретный ключ", $this->router->route());
					$result = ['status' => 'success', 'success' => "Новый ключ сгенерирован!", "key" => $secret_key];
				} else {
					$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
			}
			$this->LogModel->pushLog("Попытка генерации нового секретного ключа", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['ajax'] == "new_public") {
			$public_key = md5(md5(md5(time().$project['shop_id'])."maksa988"));
			$public_key = $public_key{1}.$public_key{2}.$public_key{3}.$public_key{4}.$public_key{5}."-".$project['shop_id'];
			if($project['user_id'] == $this->session->data['user_id']) {
				if($this->ProjectModel->set(['shop_public_key' => $public_key])->where("shop_id", "=", $id)->update()){
					$this->LogModel->pushLog("Сгенерирован новый публичный ключ", $this->router->route());
					$result = ['status' => 'success', 'success' => "Новый ключ сгенерирован!", "key" => $public_key];
				} else {
					$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
			}
			$this->LogModel->pushLog("Попытка генерации нового публичного ключа", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['ajax'] == "checkURL") {

			if($this->ProjectModel->checkURL($this->request->post['url'])){
				$result = ['status' => 'success'];
			} else {
				$result = ['status' => 'error'];
			}

			return json_encode($result);
		}

		if($this->request->post['ajax'] == "check_request") {
			$params = [
				"method" => $this->request->post['method'],
				"account" => $this->request->post['account'],
				"sum" => $this->request->post['sum'],
				"projectId" => $project['shop_id'],
				"secret_key" => $project['shop_secret_key']
			];
			$answer = $this->ProjectModel->checkURL($project['shop_url'], $params);

			return json_encode($answer);
		}

		if($this->request->post['generalInfo']) {
			$shop_name = $this->request->post['shop_name'];
			$shop_game = $this->request->post['shop_game'];
			$notif = $this->request->post['notif'];
			if($project['user_id'] == $this->session->data['user_id']) {
				if(!empty($shop_name) && !empty($shop_game)) {
					if($notif == "on") {
						$notif = 1;
					} else {
						$notif = 0;
					}

					if($this->ProjectModel->set(['shop_name' => $shop_name, 'shop_game' => $shop_game, 'shop_notify' => $notif])->where("shop_id", "=", $id)->update()) {
						$this->LogModel->pushLog("Изменение основных данных проекта", $this->router->route());
						$result = ['status' => 'success', 'success' => "Данные успешно сохранены!"];
					} else {
						$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
					}
				} else {
					$result = ['status' => 'error', 'error' => "Все поля обязательны к заполнению!"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
			}
			$this->LogModel->pushLog("Попытка изменения основных данных проекта", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['otherInfo']) {
			$shop_url = $this->request->post['shop_url'];
			$shop_fail_url = $this->request->post['shop_fail_url'];
			$shop_success_url = $this->request->post['shop_success_url'];
			if($project['user_id'] == $this->session->data['user_id']) {
				if(!empty($shop_url) or !empty($shop_fail_url) or !empty($shop_success_url)) {
					if($this->ProjectModel->set(['shop_url' => $shop_url, 'shop_fail_url' => $shop_fail_url, 'shop_success_url' => $shop_success_url])->where("shop_id", "=", $id)->update()) {
						$this->LogModel->pushLog("Изменение остальной информации проекта", $this->router->route());
						$result = ['status' => 'success', 'success' => "Данные успешно сохранены!"];
					} else {
						$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
					}
				}
			} else {
				$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
			}
			$this->LogModel->pushLog("Попытка изменения осстальных данных проекта", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['ajax'] == 'wm_request') {

			$user = $this->UserModel->getUser($this->session->data['user_id']);
			$wmr_url = "http://passport.webmoney.ru/asp/CertView.asp?purse=".$user['user_wmr'];

			$search_wmid = file_get_contents($wmr_url);
			$result = explode('" href="https://events.webmoney.ru/user.aspx?', $search_wmid);
			$wmid = explode('"><img src="/images/events26x26.png" border="0" style="vertical-align:middle;"/></a> <a target="_blank"', $result[1]);

			$wmstatus = explode('<td align="left" valign="top"><img src="../images/bat', $result['2']);
			$wmcertif = explode('.png" width="57"', $wmstatus[1]);

			if($project['user_id'] == $this->session->data['user_id']) {
				if($wmcertif[0] == "135" or $wmcertif[0] == "130") {
					$this->ProjectModel->table("gd_webmoney_requests");
					$this->ProjectModel->create(['wm_status' => "2", 'user_id' => $this->session->data['user_id'], 'shop_id' => $id, 'wm_certif' => $wmcertif[0], 'wm_wmid' => $wmid[0]]);
					$this->ProjectModel->table("gd_shops");
					$this->ProjectModel->set(['shop_webmoney' => 2])->where("shop_id", "=", $id)->update();
					$this->LogModel->pushLog("Успешно созданная заявка на подключение WM к магазину", $this->router->route());
					$result = ['status' => 'success', 'success' => "Заявка в для добавления магазина в WM успешно подана.", "type" => "0"];
				} else {
					$this->ProjectModel->set(['shop_webmoney' => 4])->where("shop_id", "=", $id)->update();
					$result = ['status' => 'error', 'error' => "На указанном вами WMR нет персонального аттестата!", "type" => "0"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
			}
			$this->LogModel->pushLog("Попытка подачи заявки на подключение WM", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['ajax'] == 'paySystem') {
			if($project['user_id'] == $this->session->data['user_id']) {
				if($project['shop_status'] == 1) {
					$systems = ['shop_webmoney', 'shop_yandex', 'shop_qiwi', 'shop_visa', 'shop_master_card', 'shop_robokassa', 'shop_ooopay', 'shop_tinkoff', 'shop_w1', 'shop_payeer', 'shop_okpay', 'shop_zpayment', 'shop_alpha_bank', 'shop_sberbank', 'shop_vtb', 'shop_promsvyazbank', 'shop_rus_standart', 'shop_mts', 'shop_tele2', 'shop_beline', 'shop_terminal_ru', 'shop_terminal_ua', 'shop_mykassa'];
					$system = $this->request->post['system'];
					if($system != "webmoney") {
						if(in_array("shop_".$system, $systems)) {
							if($project['shop_'.$system]) {
								$this->ProjectModel->set(['shop_'.$system => 0])->where("shop_id", "=", $id)->update();
								$result = ['status' => 'success', 'success' => "Метод оплаты отключен!", "type" => "0"];
							} else {
								$this->ProjectModel->set(['shop_'.$system => 1])->where("shop_id", "=", $id)->update();
								$result = ['status' => 'success', 'success' => "Метод оплаты подключен!", "type" => "1"];
							}
							$this->LogModel->pushLog("Включен / Отключен метод оплаты", $this->router->route());
						} else {
							$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
						}
					} else {
						$result = ['status' => 'error', 'error' => "Для подключения WebMoney обратитесь в поддержку!"];
					}
				} else {
					$result = ['status' => 'error', 'error' => "Проект неодобрен!"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Произошла неизвестная ошибка, повторите попытку позже!"];
			}
			$this->LogModel->pushLog("Попытка отключения / Покдлючения метода оплаты", $this->router->route());
			return json_encode($result);
		}

		$stats[1] = $this->StatsModel->getShopStatsWeek("1", (int)$id);
		$stats[2] = $this->StatsModel->getShopStatsWeek("0", (int)$id);
		$stats[3] = $this->StatsModel->getBalance("today", (int)$id); // $stats[3][0]['sum']
		$stats[4] = $this->StatsModel->getBalance("week", (int)$id); // $stats[4][0]['sum']
		$stats[5] = $this->StatsModel->getAllPayments((int)$id); // $stats[4]['total']
		$this->data['stats'] = $stats;
		$this->data['cat'] = ["1" => "samp", "2" => "rust", "3" => "cs", "4" => "other", "5" => 'mine'];

		$this->data['items'] = $this->ProjectModel->getItems(array("shop_id" => (int) $id));

		return view("project/view", $this->data);
	}

	public function addProject($shopid = null) {

		if(empty($this->session->data['user_id']))
			return view("login");

		model("Project", "User", "Log");

		if($this->request->post['addShop']) {
			$shop_name = $this->request->post['shop_name'];
			$shop_domain = $this->request->post['shop_domain'];
			$shop_game = $this->request->post['shop_game'];

			if(strpos($shop_domain, "http://") or strpos($shop_domain, "https://") or strpos($shop_domain, "/")) {
				$result = ['status' => 'error', 'error' => 'Домен введен неверно!'];
			} else {
				if(!empty($shop_domain) && !empty($shop_name) && $shop_game != 0) {
					if(!$this->ProjectModel->getProject($shop_domain, 'shop_domain')) {
						if($shopid = $this->ProjectModel->create(['shop_name' => $shop_name, 'user_id' => $this->session->data['user_id'], 'shop_domain' => $shop_domain, 'shop_game' => $shop_game, 'shop_status' => '3'])) {
							$public_key = md5(md5(md5(time().$shopid)."maksa988"));
							$public_key = $public_key{1}.$public_key{2}.$public_key{3}.$public_key{4}.$public_key{5}."-".$shopid;
							$secret_key = md5(md5(md5(time().$shopid)."maksa988"));
							$this->ProjectModel->set(['shop_public_key' => $public_key, 'shop_secret_key' => $secret_key])->where("shop_id", "=", $shopid)->update();

							$this->LogModel->pushLog("Добавлен новый проект, пройден первый этап", $this->router->route());
							$result = ['status' => 'success', 'success' => "Проект успешно добавлен, необходимо пройти этап проверки!"];
							$result['file'] = $public_key.".txt";
							$result['code'] = md5($public_key.$shopid);
							$result['shopid'] = $shopid;
						} else {
							$result = ['status' => 'error', 'error' => 'Произошла ошибка при добавлении проекта, повторите попытку позже!'];
						}
					} else {
						$result = ['status' => 'error', 'error' => 'Данный проект уже был добавлен!'];
					}
				} else {
					$result = ['status' => 'error', 'error' => 'Все поля обязательны к заполнению!'];
				}
			}
			$this->LogModel->pushLog("Попытка добавления проекта", $this->router->route());
			return json_encode($result);
		}

		if($this->request->post['checkSite']) {
			$code = $this->request->post['codeCheck'];
			$shopid = $this->request->post['shopIDNew'];

			if($shop = $this->ProjectModel->getProject((int) $shopid)) {
				if($check = @file_get_contents("http://".$shop['shop_domain']."/".$shop['shop_public_key'].".txt")) {
					if($check == md5($shop['shop_public_key'].$shopid)) {
						$this->ProjectModel->set(['shop_status' => 0])->where("shop_id", "=", $shopid)->update();
						$this->LogModel->pushLog("Пройден второй этап провверки сайта", $this->router->route());
						$result = ['status' => 'success', 'success' => 'Проект добавлен!', 'id' => $shopid];
					} else {
						$result = ['status' => 'error', 'error' => 'Код в файле неверный!'];
					}
				} else {
					$result = ['status' => 'error', 'error' => 'Файл с кодом не найден!'];
				}
			} else {
				$result = ['status' => 'error', 'error' => 'Произошла ошибка при проверке магазина!'];
			}
			$this->LogModel->pushLog("Попытка пройти второй этап проверки", $this->router->route());
			return json_encode($result);
		}

		if($shopid){
			if($shop = $this->ProjectModel->getProject((int) $shopid)) {
				$this->data['code'] = md5($shop['shop_public_key'].$shopid);
				$this->data['file'] = $shop['shop_public_key'];
				$this->data['shop'] = $shop;
				$this->LogModel->pushLog("Попытка пройти второй этап проверки с страницы проекта", $this->router->route());
			} else {
				return view("errors/404");
			}
		}

		return view("project/add", $this->data);
	}
}