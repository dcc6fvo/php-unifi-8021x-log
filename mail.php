<?php

require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class MailSender {

	var $mailer;
	var $template;
	var $body = '';
	var $body_alt = '';
   

	public function __construct($isHTML = true) {
		$mail = new PHPMailer;
		$mail->isSMTP();                              // Set mailer to use SMTP
		$mail->Host = "mail.luzerna.ifc.edu.br";  	  // Specify main and backup SMTP servers
		$mail->Port = 25;  
		$mail->isHTML($isHTML);                       // Set email format to HTML
		$mail->CharSet = 'UTF-8';
		// Save PHPMailer Instance
		$this->mailer = $mail;
	}

	/**
	 * Template .html path
	 * @param String $path 
	 */
	public function setTemplateURL($path) {
		$this->template = $path;
		$this->body = file_get_contents($this->template);
	}

	public function setBodyAlt($string) {
		$this->body_alt = $string;
	}

	/**
	 * Replace mail variables inside template with {{var}} notation.
	 * @return Array 
	 */
	public function compose($args) {
		if(is_array($args)) {
			foreach($args as $key => $value){
				if(!is_array($value)) $this->body = preg_replace('/{{'.$key.'}}/', $value, $this->body);	
			}
		}
	}

	/**
	 * Send!
	 * @param  [type] $from    [description]
	 * @param  [type] $to      [description]
	 * @param  [type] $subject [description]
	 * @return [type]          [description]
	 */
	function send($from, $to, $subject) {
		
		$this->mailer->Subject = $subject;
		$this->mailer->Body = $this->body;

		if(!empty($this->body_alt)) $this->mailer->AltBody = $this->body_alt; 
		if(is_array($from)) $this->mailer->setFrom($from[0], $from[1]);
		else $this->mailer->setFrom($from);

		if(!is_array($to)) $this->mailer->addAddress($to);
		else {
			foreach ($to as $email => $name) {
				$this->mailer->addBcc($email, $name);
			}
		}

		return $this->mailer->send();
	}
}
?>
 
