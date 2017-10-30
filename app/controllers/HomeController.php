<?php
/*
* MyUCP
*/

class HomeController extends Controller {

	public function welcome() {
		
		if(empty($this->session->data['user_id']))
			return view("login");

		model("Project", "Stats");

		$this->projects = $this->ProjectModel->getProjects("WHERE `user_id` = '{$this->session->data['user_id']}' ORDER BY `shop_id` DESC");
		$this->data['shops'] = $this->projects;

		$response = file_get_contents("https://api.vk.com/method/wall.get?owner_id=-60115896&extended=1&count=10");
		$wall = json_decode($response, true);

		$count = 0;

		foreach($wall['response']['wall'] as $item){
			$count++;
			$this->data['wall'][] = $item;
			if($count == 2): break; endif;
		}

		return view("welcome", $this->data);
	}
}