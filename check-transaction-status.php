<?php
require_once('mysqli_connect.php');
require_once('send-mail.php');
$transaction_sql = "select * from consentium_transaction where status = 'Waiting' and currency = 'ETH'";
$transaction_result = mysqli_query($dbc, $transaction_sql);
date_default_timezone_set("UTC"); 
while ($transaction = mysqli_fetch_array($transaction_result)) {
	if ((time() - strtotime($transaction['date'])) > 48 * 3600) {
		$reject_transaction_sql = "update consentium_transaction set status = 'Canceled' where transaction_id = '".$transaction['transaction_id']."'";
		mysqli_query($dbc, $reject_transaction_sql);
		echo "Canceled  <br/>";
		$name = explode("@", $transaction['user_email'])[0];
		sendMail($transaction['user_email'], getTransactionResubmissionTitle(), getTransactionResubmissionMessage($name));
	}
}
?>