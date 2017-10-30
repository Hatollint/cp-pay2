<?php
/*
* MyUCP
*/

class SupportController extends Controller {

	public function index() {
		if(empty($this->session->data['user_id']))
			return view("login");

		model("Tickets", "Log");

		if(!empty($this->request->post['sort'])){
			switch ($this->request->post['sort']) {
				case 'opened':
					$sql = "`ticket_status` >= 1";
					break;
				
				case 'closed':
					$sql = "`ticket_status` = 0";
					break;
			}
			$this->data['sort'] = true;
		} else {
			$sql = "`ticket_status` >= 1";
		}

		$this->data['tickets'] = $this->TicketsModel->getTickets("WHERE `gd_tickets`.`user_id` = {$this->session->data['user_id']} AND {$sql} ORDER BY `ticket_id` DESC");
		$this->LogModel->pushLog("Получены все тикеты на главной странице", $this->router->route());
		return view("support/list", $this->data);
	}

	public function newticket() {
		if(empty($this->session->data['user_id']))
			return view("login");

		model("Tickets", "TicketsMessages", "Project", "Log");

		$this->data['tickets'] = $this->TicketsModel->getTickets("WHERE `gd_tickets`.`user_id` = {$this->session->data['user_id']} AND `ticket_status` >= 1 ORDER BY `ticket_id` DESC");
		$this->data['shops'] = $this->ProjectModel->getProjects("WHERE `user_id` = '{$this->session->data['user_id']}' ORDER BY `shop_id` DESC");

		if($this->request->post["newTicket"]){
			$name = $this->request->post['name'];
			$text  = $this->request->post['text'];
			$dep  = $this->request->post['dep'];
			$shop  = $this->request->post['shop'];

			if(!empty($name) && !empty($text) && !empty($dep)){
				if($shop !== 0){
					if($shop == "none"){
						$shop = 0;
					}

					$ticketid = $this->TicketsModel->create(['ticket_name' => $name, 'user_id' => $this->session->data['user_id'], 'ticket_time_add' => 'NOW()', 'ticket_dep' => $dep, 'shop_id' => $shop, 'ticket_status' => "2"]);
					$this->TicketsMessagesModel->create(['ticket_message_text' => $text, 'ticket_message_time' => 'NOW()', 'ticket_id' => $ticketid, 'user_id' => $this->session->data['user_id']]);
					$this->LogModel->pushLog("Создан новый тикет", $this->router->route());
					$result = ['status' => 'success', 'success' => "Запрос в поддержку успешно создан!", "id" => $ticketid];
				} else {
					$result = ['status' => 'error', 'error' => "Все поля обязельны к заполнению!"];
				}
			} else {
				$result = ['status' => 'error', 'error' => "Все поля обязельны к заполнению!"];
			}

			return json_encode($result);
		}

		return view("support/new", $this->data);
	}

	public function view($id) {
		if(empty($this->session->data['user_id']))
			return view("login");

		model("User", "Tickets", "TicketsMessages", "Log");

		$this->data['tickets'] = $this->TicketsModel->getTickets("WHERE `gd_tickets`.`user_id` = {$this->session->data['user_id']} AND `ticket_status` >= 1 ORDER BY `ticket_id` DESC");

		if($ticket = $this->TicketsModel->getTicket($id)){
			if($ticket['user_id'] == $this->session->data['user_id']) {
				$this->data['ticket'] = $ticket;
				$this->data['messages'] = $this->TicketsMessagesModel->getMessages($id);
				$this->LogModel->pushLog("[0] Получение сообщений для тикета, ID: ".$id, $this->router->route());
			}
		} else {
			return view("errors/404");
		}
		
		if($this->request->post['ajax'] == 'getMessagess'){
			if($ticket['user_id'] == $this->session->data['user_id']) {
				$this->data['messages'] = $this->TicketsMessagesModel->getMessages($id);
				$this->data['type'] = "messages";
				$this->LogModel->pushLog("[1] Получение сообщений для тикета, ID: ".$id, $this->router->route());
				return view("support/view", $this->data);
			} else {
				return false;
			}
		} elseif($this->request->post['ajax'] == 'closeticket'){
			if($ticket['user_id'] == $this->session->data['user_id']) {
				$this->TicketsModel->where("ticket_id", "=", $id)->set(['ticket_status' => 0])->update();
				$this->LogModel->pushLog("Закрытие тикета, ID: ".$id, $this->router->route());
				return true;
			} else {
				return false;
			}
		} elseif($this->request->post['ajax'] == 'addmessage'){
			if($ticket['user_id'] == $this->session->data['user_id']) {
				$text = $this->request->post['text'];

				if(!empty($text)){
					$this->TicketsMessagesModel->create(["user_id" => $this->session->data['user_id'], "ticket_id" => $id, "ticket_message_text" => $text, 'ticket_message_time' => 'NOW()']);
					$this->TicketsModel->where("ticket_id", "=", $id)->set(['ticket_status' => 2])->update();
					$this->LogModel->pushLog("Отправлено новое сообщение в тикет, ID: ".$id, $this->router->route());
					$result = ["status" => "success", 'success' => "Сообщение успешно добавлено!"];
				} else {
					$result = ['status' => 'error', 'error' => "Введите текст сообщения!"];
				}
				return json_encode($result);
			} else {
				return false;
			}
		} elseif($this->request->post['ajax'] == 'getTicket'){
			if($ticket['user_id'] == $this->session->data['user_id']) {
				$this->data['messages'] = $this->TicketsMessagesModel->getMessages($id);
				$this->data['ticket'] = $this->TicketsModel->getTicket($id);
				$this->data['type'] = "block";
				$this->LogModel->pushLog("Получение тикета, ID: ".$id, $this->router->route());
				return view("support/view", $this->data);
			} else {
				return false;
			} 
		}

		return view("support/view", $this->data);
	}

	public function notifications() {
		model("Tickets", "TicketsMessages");
		$userid = $this->session->data['user_id'];
		$tickets = $this->TicketsModel->getTickets("WHERE `site_tickets`.`user_id` = '{$userid}'");

		$count = 0;
		foreach($tickets as $item){
			$messages = $this->db->getOne("SELECT COUNT(*) FROM `site_ticket_messages` WHERE `ticket_id` = '{$item['ticket_id']}'");
			$count = $count + $messages;
		}

		return $count;
	}
}