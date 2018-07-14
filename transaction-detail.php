<?php
	require_once('mysqli_connect.php');
	require_once('send-mail.php');
	if(isset($_POST['currency'])) {
		$update_sql = "update transactions set currency='"
		.$_POST['currency']."', amount='"
		.$_POST['amount']."', address='"
		.$_POST['address']."', token_amount='"
		.$_POST['token_amount']."', token_bonus='"
		.$_POST['token_bonus']."', conversion_rate='"
		.$_POST['conversion_rate']."', status='"
		.$_POST['status']."', date='"
		.$_POST['date']."' where transaction_id='"
		.$_POST['transaction_id']."'";
		mysqli_query($dbc, $update_sql);
		
		if ($_POST['status'] == "Confirmed") {
			$user_sql = "select * from users where email='".$_POST['user_email']."'";
			$user_result = mysqli_query($dbc, $user_sql);
			$user = mysqli_fetch_array($user_result);
			$token_number = $user['token_number'] + $_POST['token_amount'] + $_POST['token_bonus'];
			$update_token_sql = "update users set token_number='".$token_number."' where email='"
			.$_POST['user_email']."'";
			sendMail($_POST['user_email'], getSuccessTransactionTitle(), getSuccessTransactionMessage($user['last_name'], $user['wallet_address']));
			mysqli_query($dbc, $update_token_sql);
		}
	}
	$sql = "select * from transactions where transaction_id='".$_POST['transaction_id']."'";
	$result = mysqli_query($dbc, $sql);
	$transaction = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Transaction detail</title>
	<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="modal-style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style_admin.css">
</head>
<body>
<div class="menu" id="menu">
	<div id="logo"> </div>
	<ul>
		<li><a class="link" href="user-list.php">Users</a></li>
		<li><a class="link" href="transaction-list.php">Transactions</a></li>
		<li><a class="link" href="#" onclick="editTransaction()" <?php if ($transaction['status'] == "Confirmed") echo "hidden"; ?>>Edit transaction</a></li>
		<li><a class="logout" href="#" onclick="logOut()">Logout</a></li>
	</ul>
</div>
<h1>Transaction detail</h1>

<div class="content">
	<form action="transaction-detail.php" method="POST" id="transaction_detail">
	
	<div class="inline width-30">
		Email:<br/>
		<input type="text" name="user_email" value="<?php echo $transaction['user_email'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Currency:<br/>
		<input type="text" name="currency" value="<?php echo $transaction['currency'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Amount:<br/>
		<input type="text" name="amount" value="<?php echo $transaction['amount'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Address:<br/>
		<input type="text" name="address" value="<?php echo $transaction['address'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Token amount:<br/>
		<input type="text" name="token_amount" value="<?php echo $transaction['token_amount'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Conversion rate:<br/>
		<input type="text" name="conversion_rate" value="<?php echo $transaction['conversion_rate'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Token bonus:<br/>
		<input type="text" name="token_bonus" value="<?php echo $transaction['token_bonus'] ?>" readonly>
	</div>
	<div class="inline width-30">
		Status:<br/>
		<select type="text" name="status" id="status" disabled>
			<option <?php if($transaction['status'] == 'Confirmed') echo "selected"; ?>>Confirmed</option>
			<option <?php if($transaction['status'] == 'Waiting') echo "selected"; ?>>Waiting</option>
			<option <?php if($transaction['status'] == 'Canceled') echo "selected"; ?>>Canceled</option>
		</select>
	</div>
	<div class="inline width-30">
		Date:<br/>
		<input type="text" name="date" value="<?php echo $transaction['date'] ?>" readonly>
	</div>
	<input type="hidden" name="transaction_id" value="<?php echo $_POST['transaction_id'] ?>">
	</form>
</div>
<div id="edit_btns" hidden="hidden" class="center">
	<button class="bg1" onclick="saveProfile()">Save</button>
	<button class="bg2" onclick="cancelEdit()">Cancel</button>
</div>
<script type="text/javascript">
function editTransaction(){
	var inputs = document.getElementsByTagName('input');
	for (var i = 1; i < inputs.length; i++) {
		inputs[i].readOnly = false;
		inputs[i].style.backgroundColor = "white";
	}
	document.getElementById("edit_btns").hidden = false;
	document.getElementById("menu").hidden = true;
	document.getElementById("status").disabled = false;
	document.getElementById("status").style.backgroundColor = "white";
}

function cancelEdit() {
	var inputs = document.getElementsByTagName('input');
	for (let index of inputs) {
		index.readOnly = true;
		index.style.backgroundColor = "#DEDDDD";
	}
	document.getElementById("edit_btns").hidden = true;
	document.getElementById("menu").hidden = false;
	document.getElementById("status").disabled = true;
	document.getElementById("status").style.backgroundColor = "#DEDDDD";
}

function saveProfile() {
	form = document.getElementById("transaction_detail");
	form.submit();
}

function logOut() {
	document.cookie = "user=";
	window.open("admin.php", "_self");
}
</script>
</body>
</html>