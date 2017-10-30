<?php

class ProjectModel extends Model {

	protected $table = "gd_shops";

	public function getProjects($param = '') {
		$sql .= "SELECT * FROM `{$this->table}` " . $param;
		return $this->db->getAll($sql);
	}

	public function getProject($val, $row = "shop_id") {
		$sql = "SELECT * FROM `{$this->table}` WHERE `{$row}` = '{$val}' LIMIT 1";
		return $this->db->getRow($sql);
	}

	public function getItems($data = array(), $joins = array()){
		$sql = "SELECT * FROM `gd_log_payments`";
		foreach($joins as $join) {
			$sql .= " LEFT JOIN `gd_{$join}`";
			switch($join) {
				case "shops":
					$sql .= " ON `gd_log_payments`.shop_id=`gd_shops`.shop_id";
					break;
			}
		}
		
		if(!empty($data)) {
			$count = count($data);
			$sql .= " WHERE";
			foreach($data as $key => $value) {
				$sql .= " $key = '" . ($value) . "'";
				
				$count--;
				if($count > 0) $sql .= " AND";
			}
		}
		$sql .= ' ORDER BY `log_payments_id` DESC';

		return $this->db->getAll($sql);
	}

	public function checkURL($url, $param = false){
		if(!$param) {
			$status = trim(@file_get_contents($url));
			$status = json_decode($status, true);
			
			if($status['error']['message'] == "Invalid request") {
				return true;
			} else {
				return false;
			}
		} else {
			$sign = md5($param['account'].$param['sum'].$params['secret_key']);
			$r_url = $url."?method=".$param['method']."&params[account]=".$param['account']."&params[projectId]=".$param['projectId']."&params[sum]=".$param['sum']."&params[sign]=".$sign."&params[gdonateId]=0001";
			return ['answer' => trim(@file_get_contents($r_url)), 'url' => $r_url];
		}
	}
}