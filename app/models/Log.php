<?php
/*
* MyUCP
*/

class LogModel extends Model {
	
	protected $table = "gd_logs";

	public function pushLog($text, $router) {
		// dd($router);
		$this->create(['log_time' => "NOW()", 'log_text' => $text, 'log_ip' => $this->request->server['REMOTE_ADDR'], 'log_router' => $this->getString($router), 'log_post' => $this->getString($this->request->post), 'log_get' => $this->getString($this->request->get), 'log_session' => $this->getString($this->session->data)]);
	}

	private function getString($param) {
		$result = "";
		foreach($param as $key => $value) {
			$result .= $key.": ".$value."; ";
		}

		return $result;
	}
}
