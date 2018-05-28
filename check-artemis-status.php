<?php
	require_once('mysqli_connect.php');
	require_once('request_api.php');
	$url = "https://p3.cynopsis.co/artemis_novumcapital/default/individual_risk";
	$header = ['Content-Type: application/json', 'WEB2PY-USER-TOKEN:03a7a6cb-63b2-47b2-8715-af65aabf28ed'];
	$sql_pending_user = "select * from consentium_user where last_name='Gusmar'";
	$result_pending_user = mysqli_query($dbc, $sql_pending_user);
	while ($user = mysqli_fetch_array($result_pending_user)) {
		$data = array (
			"rfrID"=>$user['user_id'],
			"first_name"=>$user['first_name'],
			"last_name"=>$user['last_name'],
			"date_of_birth"=>$user['date_birth'],
			"nationality"=>$user['citizenship'],
			"country_of_residence"=>$user['country'],
			"ssic_code"=>"UNKNOWN",
			"ssoc_code"=>"UNKNOWN",
			"onboarding_mode"=>"NON FACE-TO-FACE",
			"payment_mode"=>"UNKNOWN",
			"product_service_complexity"=>"COMPLEX",
			"emails"=>[$user['email']],
			"domain_name"=>"NOVUMCAPITAL"
		);
		var_dump($data);
		$result = callAPI("POST", $url, $data, $header);
		$data = json_decode($result);
		if ($data) {
			if (isset($data->approval_status)) {
				$status = $data->approval_status;
				if ($status == "CLEARED"){
					$sql_update_status = "update consentium_user set status='".$status."' where user_id ='".$user['user_id']."'";
				}
			}	
		}
	}
	
	mysqli_close($dbc);
?>