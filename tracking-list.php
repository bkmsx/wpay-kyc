<?php
	if(empty($_COOKIE['user']) || $_COOKIE['user'] != 'NoVum'){
		echo "You don't have access to this page";
		exit;
	}
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
<h1>User Tracking list</h1>
<table>
	<tr>
		<th>#</th>
		<th>Email</th>
		<th>Name</th>
		
		<th>Action</th>
	</tr>
<?php
require_once('mysqli_connect.php');
$sql = "select * from users";
$result = mysqli_query($dbc, $sql);
$id = 0;
while ($user = mysqli_fetch_array($result)) {
	$id += 1;
	echo "<tr>";
	echo "<td>".$id."</td>";
	echo "<td><a href='' class='highlight-text'>".$user['email']."</a></td>";
	echo "<td>".$user['first_name']." ".$user['last_name']."</td>";

	echo "<td><a href='user-tracking-list.php?id=".$user['user_id']."' class='highlight-text'>View</a></td>";
	echo "</tr>";
}
mysqli_close($dbc);
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
