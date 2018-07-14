<?php
	
	if(isset($_POST['submit'])){
		
		if(empty($_POST['g-recaptcha-response'])) {
			$err = "* Please check captcha";
		} 
		elseif ($_POST['user'] == "beepbeep" && $_POST['password'] == "Deamnoon3!#"){
			header("Location: transaction-list.php");
			setcookie('user', 'NoVum');
		} else {
			$err = "* Username or password are not correct";
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin login</title>
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<link rel="stylesheet" type="text/css" href="style_admin.css"/>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
	<div class="center">
		<h1>Login panel</h1>
		<label id="error" style="color: red;"><?php if(isset($err)) echo $err;?></label>
		<form action="admin.php" method="POST">
			<div id="admin" class="center">
				<input type="text" name="user" placeholder="User name"><br/><br/>
				<input type="password" name="password" placeholder="Password"><br/><br/>
				<div id="captcha" class="g-recaptcha" data-sitekey="6Lf551oUAAAAAJjI_qlCT6RRFeatWbhkklQlyM33"></div><br/><br/>
				<input type="submit" name="submit" value="Login">
			</div>
		</form>
	</div>
</body>
</html>

