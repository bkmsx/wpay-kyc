<?php
?>
<!DOCTYPE html>
<html>
<head>
<title>Transaction list</title>
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style_admin.css">
<script type="text/javascript">
function logOut() {
    document.cookie = "user=";
    window.open("admin.php", "_self");
}
function showUserDetail(email){
	var form = document.createElement('form');
	form.method = 'POST';
	form.action = "user-detail.php";
	var input = document.createElement('input');
	input.name = "email";
	input.value = email;
	input.type = 'hidden';
	form.appendChild(input);
	document.body.appendChild(form);
	form.submit();
}
function showTransactionDetail(transaction_id){
	var form = document.createElement('form');
	form.method = 'POST';
	form.action = "transaction-detail.php";
	var input = document.createElement('input');
	input.name = "transaction_id";
	input.value = transaction_id;
	input.type = 'hidden';
	form.appendChild(input);
	document.body.appendChild(form);
	form.submit();
}
</script>
</head>
<body>
<div class="menu">
<div id="logo"> </div>

<ul>
	<li><a class="link" href="user-list.php">Users</a></li>
		<li><a class="link" href="transaction-list.php">Transactions</a></li>
		<li><a class="link" href="tracking-list.php">Tracking</a></li>
		<li><a class="logout" href="#" onclick="logOut()">Logout</a></li>
</ul>
</div>
<h1>Transaction list</h1>
<div style="overflow-x:auto;">
<table>
    <tr valign="center">
	  <th>#</th>
      <th>DATE</th>
      <th>EMAIL</th>
      <th>CURRENCY</th>
      <th>AMOUNT</th>
      <th>ADDRESS</th>
      <th>TOKEN AMOUNT</th>
      <th>TOKEN BONUS</th>
      <th>CONVERSION RATE</th>
      <th>STATUS</th>
    </tr>
	<?php 
	  require_once('mysqli_connect.php');	
	  $transaction_history_sql = "select * from transactions order by date desc";
	  $result = mysqli_query($dbc, $transaction_history_sql);
	  $index = 1;
	  while ($transaction = mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$index."</td>";
	    echo "<td>".$transaction['date']."</td>";
	    echo "<td><a href='javascript: showUserDetail(\"".$transaction['user_email']."\")' class='highlight-text'>".$transaction['user_email']."</a></td>";
	    echo "<td>".$transaction['currency']."</td>";
	    echo "<td>".$transaction['amount']."</td>";
	    echo "<td>".$transaction['address']."</td>";
	    echo "<td>".$transaction['token_amount']."</td>";
	    echo "<td>".$transaction['token_bonus']."</td>";
	    echo "<td>".$transaction['conversion_rate']."</td>";
	    echo "<td><a href='#' class='highlight-text' onclick='showTransactionDetail(\"".$transaction['transaction_id']."\")'>".$transaction['status']."</a></td>";
		echo "</tr>";
		$index += 1;
	  }
	  mysqli_close($dbc);
	?> 
</table>
</div>
</body>
</html>