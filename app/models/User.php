<?php
/*
* MyUCP
*/

class UserModel extends Model {
	
	protected $table = "gd_users";

	public function getUser($value, $row = "user_id") {
		return $this->db->getRow("SELECT * FROM `{$this->table}` WHERE `{$row}` = '{$value}'");
	}

	public function sendRestore($email, $code) {
		$body = view("email/restore", ["code" => $code]);
		$headers = "From: support@localpay.ru\r\nReply-To: support@localpay.ru\r\n";
	    $headers .= "MIME-Version: 1.0\r\n";
	    $headers .= "Content-Type: text/html; charset=utf-8;";
	    $mbody .= $body."\r\n\r\n";
	    $result = mail($email, "LocalPay | Восстановление пароля", $mbody, $headers);
	}

	public function sendSecureRequest($user_id, $code) {
		$this->table("gd_users");
		$user = $this->getUser($user_id);
		$email = $user['user_email'];

		$body = view("email/secure", ["code" => $code]);
		// $headers = "From: no-reply@localpay.ru\r\nReply-To: no-reply@localpay.ru\r\n";
	 //    $headers .= "MIME-Version: 1.0\r\n";
	 //    $headers .= "Content-Type: text/html; charset=utf-8;";
	 //    $mbody .= $body."\r\n\r\n";
	 //    $result = mail($email, "LocalPay | Подтверждение действий", $mbody, $headers);
		// dd($user_id);
		// dd($this->config->mail);
	    $this->smtpmail($email, "LocalPay | Подтверждение действий", $body);
	}

	public function addSecureRequest($type, $user_id, $value) {

		$sec_code = md5(time()."maksa988.sec_code");
		if($type == 1) {
			$this->table("gd_secure_requests");
			$this->create(["user_id" => $user_id, 
						   "sec_type" => $type, 
						   "sec_time" => 'NOW()', 
						   "sec_password" => $value,
						   "sec_code" => $sec_code
						  ]);
			$this->sendSecureRequest($user_id, $sec_code);
		} elseif($type == 2) {
			$this->table("gd_secure_requests");
			$this->create(["user_id" => $user_id, 
						   "sec_type" => $type, 
						   "sec_time" => 'NOW()', 
						   "sec_wmid" => $value[0],
						   "sec_qiwi" => $value[1],
						   "sec_code" => $sec_code
						  ]);
			$this->sendSecureRequest($user_id, $sec_code);
		}

		return true;
	}

	public function confirmSecureRequest($code) {
		$this->table("gd_secure_requests");
		$secreq = $this->db->getRow("SELECT * FROM `{$this->table}` WHERE `sec_code` = '{$code}'");
		if(!empty($secreq) && $secreq['sec_status'] != 1) {
			$this->set(['sec_status' => 1])->where("sec_code", "=", $code)->update();

			$type = $secreq['sec_type'];
			$newpassword = $secreq['sec_password'];
			$userid = $secreq['user_id'];
			$wm = $secreq['sec_wmid'];
			$qiwi = $secreq['sec_qiwi'];

			if($type == 1) {
				$this->table("gd_users");
				$this->set(['user_password' => $newpassword])->where("user_id", "=", $userid)->update();
			} elseif($type == 2) {
				$this->table("gd_users");
				$this->set(['user_wmr' => $wm, 'user_qiwi' => $qiwi])->where("user_id", "=", $userid)->update();
			}

			return true;
		}

		return false;
	}

	function smtpmail($mail_to, $subject, $message) { 
		require './mailer/PHPMailerAutoload.php'; 

		$mail = new PHPMailer; // Enable verbose debug output 
		$mail->CharSet = 'utf-8'; 
		$mail->isSMTP(); 
		$mail->Host = $this->config->mail['smtp']['smtp_host']; 
		$mail->SMTPAuth = true; 
		$mail->Username = $this->config->mail['smtp']['smtp_username']; 
		$mail->Password = $this->config->mail['smtp']['smtp_password']; 
		$mail->SMTPSecure = 'ssl'; 
		$mail->Port = $this->config->mail['smtp']['smtp_port']; 

		$mail->setFrom($this->config->mail['smtp']['smtp_from']); 
		$mail->addAddress($mail_to); // Name is optional 
		$mail->isHTML(true); // Set email format to HTML 

		$mail->Subject = $subject; 
		$mail->Body = $message; 

		if(!$mail->send()) { 
			return 'Mailer Error: ' . $mail->ErrorInfo; 
		} 
		return true; 
	}
}


// Type:
// 1 - Pass
// 2 - Wallets