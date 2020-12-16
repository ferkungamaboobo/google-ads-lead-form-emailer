<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// If necessary, update with PHPMailer file location
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$mailer_host = ''; // String of your mail hostname
$mailer_user = ''; // String of your mail username 
$mailer_pass = ''; // String of your mail password
$mailer_port = 587; // Takes integer, typically 587 for TLS, 465 for SSL
$mailer_addr = array('','',''); //array of strings of recipient emails

$mailer_smtp_encryption = PHPMailer::ENCRYPTION_STARTTLS; // PHPMailer::ENCRYPTION_STARTTLS for TLS | or | PHPMailer::ENCRYPTION_SMTPS for SSL

$lead_form_json = file_get_contents('php://input');

if ($lead_form_json != '') {
	$json_decoded = json_decode($lead_form_json, true);
	$json_decoded_field_data = $json_decoded["user_column_data"];
	$json_decoded_mail_body = "";
	foreach ($json_decoded_field_data as &$fields) {
		$json_decoded_mail_body.=$fields["column_name"].": ".$fields["string_value"];
		$json_decoded_mail_body.="\r\n";
	}
	$json_decoded_mail_body.="\r\n";	
	if ($json_decoded["google_key"] != "") {
		$json_decoded_mail_body.=$json_decoded["google_key"];
	}
	else {
		$json_decoded_mail_body.="WARNING: no google key"; 
	}
	$json_decoded_mail_body.="\r\n\r\nID Hashes:\r\n";
	$json_decoded_mail_body.="Lead ID: ".$json_decoded["lead_id"];
	$json_decoded_mail_body.="\r\n";
	$json_decoded_mail_body.="Form ID: ".$json_decoded["form_id"];
	$json_decoded_mail_body.="\r\n";
	if ($json_decoded["gcl_id"] != "") {
		$json_decoded_mail_body.="GCLID: ".$json_decoded["gcl_id"];
	}
	else {
		$json_decoded_mail_body.="WARNING: no gclid"; 
	}
	$json_decoded_mail_body.="\r\n";	
}
else {
	$json_decoded_mail_body = 'url test';
	echo 'hello hackerz';
}

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = $mailer_host;                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $mailer_user;                     // SMTP username
    $mail->Password   = $mailer_pass;                               // SMTP password
    $mail->SMTPSecure = $mailer_smtp_encryption;        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = $mailer_port;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($mailer_user, 'Gooogle Ads Lead Form Extension Submission');
	foreach ($mailer_addr as &$email_addr) {
		$mail->addAddress($email_addr);     // Add a recipient
	}

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'Lead from Google Ads Lead Form Extension';
    $mail->Body    = $json_decoded_mail_body;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
