<?php

class TicketsMessagesModel extends Model {

	protected $table = "gd_tickets_messages";

	public function getMessages($ticketid) {
		$sql = "SELECT * FROM `{$this->table}` LEFT JOIN `gd_users` ON {$this->table}.user_id=gd_users.user_id WHERE `ticket_id` = '{$ticketid}' ORDER BY `ticket_message_time` ASC";
		return $this->db->getAll($sql);
	}
}