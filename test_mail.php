<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
$email = "tien@novum.capital";
$name = explode("@", $email)[0];
sendMail($email, getUsdTransactionDetailTitle(), getUsdTransactionDetailMessage($email, 200));
function sendMail($to, $subject, $message) {
	$mail = new PHPMailer;
	try {
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = "hello@consentium.net";
		$mail->Password = "consentium@12345";

	    $mail->setFrom('hello@consentium.net', 'The Consentium Team');
	    $mail->addAddress($to); 
	    //Content
	    $mail->isHTML(true);                               
	    $mail->Subject = $subject;
	    $mail->Body    = $message;
	    $mail->send();
	} catch (Exception $e) {
	    
	}
}

function sendMails($to, $subject, $message) {
	$headers = "From: support@novum.capital\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	mail($to,$subject,$message,$headers);	
}

function getApplyTransactionMessage($username) {
	$message = file_get_contents("mail_templates/apply_transaction.html");
	$message = str_replace("%username%", $username, $message);
	return $message;
}

function getApplyTransactionTitle() {
	$title = "Thank you for submitting your transaction details!";
	return $title;
}

function getApplyKycMessage($username) {
	$message = file_get_contents("mail_templates/apply_kyc.html");
	$message = str_replace("%username%", $username, $message);
	return $message;
}

function getApplyKycTitle() {
	$title = "Thank you for participating in our KYC!";
	return $title;
}

function getSuccessTransactionMessage($username) {
	$message = file_get_contents("mail_templates/success_transaction.html");
	$message = str_replace("%username%", $username, $message);
	return $message;
}

function getSuccessTransactionTitle() {
	$title = "Yay, your payment has been verified!";
	return $title;
}

function getSuccessKycMessage($username, $walletaddress) {
	$message = file_get_contents("mail_templates/success_kyc.html");
	$message = str_replace("%username%", $username, $message);
	$message = str_replace("%walletaddress%", $walletaddress, $message);
	return $message;
}

function getSuccessKycTitle() {
	$title = "Yay, your account has been approved!";
	return $title;
}

function getResubmissionMessage($username) {
	$message = file_get_contents("mail_templates/resubmission.html");
	$message = str_replace("%email%", $username, $message);
	return $message;
}

function getResubmissionTitle() {
	$title = "Uh-oh, please complete your KYC submission!";
	return $title;
}

function getTransactionResubmissionMessage($username) {
	$message = file_get_contents("mail_templates/resubmission_transaction.html");
	$message = str_replace("%email%", $username, $message);
	return $message;
}

function getTransactionResubmissionTitle() {
	$title = "[Payment Expired] Please re-submit contribution details!";
	return $title;
}

function getUsdTransactionDetailMessage($email, $amount) {
	$message = file_get_contents("mail_templates/usd_transaction_detail.html");
	$message = str_replace("%email%", $email, $message);
	$message = str_replace("%amount%", $amount, $message);
	return $message;
}

function getUsdTransactionDetailTitle() {
	$title = "Please complete your Consentium purchase!";
	return $title;
}
?>