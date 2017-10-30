<?php

class TicketsModel extends Model {

	protected $table = "gd_tickets";

	public function getTickets($param = '') {
		$sql .= "SELECT * FROM `{$this->table}` ";
		$sql .= " LEFT JOIN gd_users";
		$sql .= " ON `{$this->table}`.user_id=`gd_users`.user_id ";
		$sql .= " LEFT JOIN gd_shops";
		$sql .= " ON `{$this->table}`.shop_id=`gd_shops`.shop_id ";
		$sql .= $param;
		return $this->db->getAll($sql);
	}

	public function getTicket($id) {
		$sql = "SELECT * FROM `{$this->table}` WHERE `ticket_id` = '{$id}' LIMIT 1";
		return $this->db->getRow($sql);
	}
}