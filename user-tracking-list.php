<?php
	if(empty($_COOKIE['user']) || $_COOKIE['user'] != 'NoVum'){
		echo "You don't have access to this page";
		exit;
	}
	require_once('mysqli_connect.php');
	$id=$_GET['id'];
	$sqls = "select * from users where user_id = '$id'";
	$results = mysqli_query($dbc, $sqls);
	$users = mysqli_fetch_array($results);
	$email = $users['email'];
	$name = $users['first_name']." ".$users['last_name'];
	$clickid = $users['click_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>User list</title>
	<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="modal-style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="style_admin.css">
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
<h1><?php echo $name . "(" . $email . ")";
 ?></h1>
<table>
	<tr>
		<th>Affiliate Number</th>
		<th>Email</th>
		<th>Name</th>
		
		
	</tr>
<?php
require_once('mysqli_connects.php');	
$sqls = "select * from xperiences_affiliates where affiliate_number = '$clickid'";
$results = mysqli_query($dbc1, $sqls);
$id = 0;
while ($users = mysqli_fetch_array($results)) {
	$id += 1;
	echo "<tr>";
	echo "<td>".$users['affiliate_number']."</td>";
	echo "<td>".$users['affiliate_email']."</td>";
	echo "<td>".$users['affiliate_name']."</td>";
	

	
	echo "</tr>";
}
mysqli_close($dbc1);
?>
</table>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01"/>

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>

<script type="text/javascript">
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

function showImage(image_source, name) {
	var modal = document.getElementById('myModal');
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");
	
    modal.style.display = "block";
    modalImg.src = image_source;
    captionText.innerHTML = name;

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
	  modal.style.display = "none";
	}
}

function logOut() {
    document.cookie = "user=";
    window.open("admin.php", "_self");
}
</script>
</body>
</html>
