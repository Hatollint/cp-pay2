<?php
/*
* MyUCP
*/

class StatsModel extends Model {
	
	protected $table = "gd_log_payments";

	public function getShopStatsWeek($status = "1", $shopid) {
		if($status == "1"){
			$sql = "SELECT DATE( `log_payments_time` ) AS DATE, COUNT( * ) AS stat 
			FROM `gd_log_payments` 
			WHERE `shop_id` = '{$shopid}' AND `log_payments_time` BETWEEN NOW( ) - INTERVAL 7 DAY AND NOW( ) 
			GROUP BY DATE( `log_payments_time` ) 
			ORDER BY `log_payments_time` LIMIT 0, 7";
		} else {
			$sql = "SELECT DATE( `log_payments_time_complete` ) AS DATE, SUM( `log_payments_sum_client` ) AS sum 
			FROM `gd_log_payments` 
			WHERE `shop_id` = '{$shopid}' AND `log_payments_time` BETWEEN NOW( ) - INTERVAL 7 DAY AND NOW( ) 
			GROUP BY DATE( `log_payments_time_complete` ) 
			ORDER BY `log_payments_time_complete` LIMIT 0, 7";
		}
		return $this->db->getAll($sql);
	}

	public function getStatsWeek($shops = array()) {

		if(!empty($shops)) {
			$count = count($shops);
			foreach($shops as $item) {
				$sqlShop .= " `shop_id` = '" . (int) $item . "'";
				
				$count--;
				if($count > 0) { $sqlShop .= " OR"; }
				else { $sqlShop .= " AND"; }
			}
		}

		$sql = "SELECT DATE( `log_payments_time_complete` ) AS DATE, COUNT( * ) AS stat, SUM( `log_payments_sum_client` ) AS sum 
		FROM `gd_log_payments` 
		WHERE {$sqlShop} `log_payments_time_complete` BETWEEN NOW( ) - INTERVAL 7 DAY AND NOW( ) 
		GROUP BY DATE( `log_payments_time_complete` ) 
		ORDER BY `log_payments_time_complete` LIMIT 0, 7";
		// dd($sql);
		return $this->db->getAll($sql);
	}

	public function getBalanceAll($status = "today", $shops = array()) {

		if(!empty($shops)) {
			$count = count($shops);
			foreach($shops as $item) {
				$sqlShop .= " `shop_id` = '" . (int) $item . "'";
				
				$count--;
				if($count > 0) { $sqlShop .= " OR"; }
				else { $sqlShop .= " AND"; }
			}
		}

		if($status == "today"){
			$sql = "SELECT SUM( `log_payments_sum_client` ) as sum FROM `gd_log_payments` WHERE {$sqlShop} log_payments_time_complete >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)";
		} else {
			$sql = "SELECT SUM( `log_payments_sum_client` ) as sum FROM `gd_log_payments` WHERE {$sqlShop} log_payments_time_complete >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)";
		}

		return $this->db->getOne($sql);
	}

	public function getBalance($status = "today", $shopid) {

		if($status == "today"){
			$sql = "SELECT SUM( `log_payments_sum_client` ) as sum FROM `gd_log_payments` WHERE `shop_id` = '{$shopid}' AND log_payments_time_complete >= DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)";
		} else {
			$sql = "SELECT SUM( `log_payments_sum_client` ) as sum FROM `gd_log_payments` WHERE `shop_id` = '{$shopid}' AND log_payments_time_complete >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)";
		}

		return $this->db->getAll($sql);
	}

	public function getAllPayments($shopid){

		return $this->db->getOne("SELECT COUNT(*) as total FROM `gd_log_payments` WHERE `shop_id` = '{$shopid}'");
	}
}