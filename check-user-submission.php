<?php
require_once('mysqli_connect.php');
require_once('send-mail.php');
$user_sql = "select * from consentium_user where first_name is null";
$user_result = mysqli_query($dbc, $user_sql);
while ($user = mysqli_fetch_array($user_result)){
	$name = explode("@", $user['email'])[0];
	sendMail($user['email'], getResubmissionTitle(), getResubmissionMessage($name));
}
?>