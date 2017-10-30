<?php 

class Maksa {

	public $registry;
	public $config;
	public $projects;
	public $logcoockie = false;

	public function __construct() {

		global $registry;
		$this->registry = $registry;
		$this->config = $tihs->registry->config;

		if(!empty($this->registry->session->data['user_id']))
			$this->getProjects($this->registry->session->data['user_id']);

		if(empty($this->registry->session->data['user_id'])) {
			$token = $this->registry->request->cookie['__token'];

			if(!empty($token)) {
				model("User");

				if($user = $this->registry->UserModel->getUser($token, "user_token")){
					$this->registry->session->data['user_id'] = $user['user_id'];
					$this->logcoockie = true;
				}
			}
		}
	}

	public function user($id = null) {
		if(!$id){
			$id = $this->registry->session->data['user_id'];
		}

		model("User");
		return $this->registry->UserModel->where("user_id", "=", "{$id}")->get();
	}

	public function getProjects($userid) {

		model("Project");
		$this->projects = $this->registry->ProjectModel->getProjects("WHERE `user_id` = '{$userid}' ORDER BY `shop_id` DESC");
	}
}