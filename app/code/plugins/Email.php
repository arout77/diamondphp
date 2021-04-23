<?php
namespace App\Plugin;
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require_once VENDOR_PATH . 'phpmailer/phpmailer/src/Exception.php';
require_once VENDOR_PATH . 'phpmailer/phpmailer/src/PHPMailer.php';
require_once VENDOR_PATH . 'phpmailer/phpmailer/src/SMTP.php';

class Email {

	public function __construct(
		public string $host = '', 
		public string $user = '', 
		public string $pass = '', 
		public int $port = 587, 
		public bool $secure = true, 
		public bool $smtp = true, 
		public bool $smtp_auth = true, 
		public bool $html = true, 
		public int $debug = 0,
	) {}

	public function send( $to, $to_name, $from, $from_name, $subject, $message ) {
		//Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {

			if($this->debug === 1 || $this->debug === 2) { 
				//Enable verbose debug output
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			}
			if($this->smtp === true) { 
				//Send using SMTP
				$mail->isSMTP();
			}
			$mail->Host       = $this->host;          			//Set the SMTP server to send through
			$mail->SMTPAuth   = $this->smtp_auth;               //Enable SMTP authentication
			$mail->Username   = $this->user;         			//SMTP username
			$mail->Password   = $this->pass;               		//SMTP password
			if($this->secure === true) {
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			}	
			$mail->Port       = $this->port;                            //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom($from, $from_name);
			$mail->addAddress($to, $to_name); //Add a recipient
			                                                           // $mail->addAddress('ellen@example.com');           //Name is optional
			$mail->addReplyTo($from, $from_name);
			// $mail->addCC('cc@example.com');
			// $mail->addBCC('bcc@example.com');

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');      //Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

			                     //Content
			$mail->isHTML($this->html); //Set email format to HTML
			$mail->Subject = $subject;
			if($this->html === true) {
				$mail->Body    = $message;
			}else{
				$mail->AltBody = $message;
			}

			return $mail->send();

		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}

}