<?php
if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPass = $_POST['confirm_pass'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$err = "* Invalid email format";
		include 'sign-up.html';
		exit;
	}

	if (strlen($password) < '6') {
		$err = "* Password must contain at least 6 characters";
		include 'sign-up.html';
		exit;
    }
    elseif(!preg_match("#[0-9]+#",$password)) {
		$err = "* Password must contain number!";
		include 'sign-up.html';
		exit;
    }
    elseif(!preg_match("#[A-Z]+#",$password)) {
		$err = "* Password must contain capital letter";
		include 'sign-up.html';
		exit;
    }
    elseif(!preg_match("#[a-z]+#",$password)) {
		$err = "* Password must contain lowercase letter";
		include 'sign-up.html';
		exit;
    } elseif($password != $confirmPass) {
		$err = "* Passwords are not matched";
		include 'sign-up.html';
		echo "<script type='text/javascript'>document.getElementsByName('email')[0].value='".$email."';</script>";
		exit;
	}
	
	require_once('mysqli_connect.php');
	$query = "select * from bbn_user where email = '$email'";
	$result = @mysqli_query($dbc, $query);
	if (mysqli_num_rows($result) > 0){
		$err = "* Email already exists";
		include 'sign-up.html';
		exit;
	} else {
		
		$encrypt_pass = password_hash($password, PASSWORD_BCRYPT);
		$sql_count_row = "select count(user_id) as row_count from bbn_user";
		$row_count = mysqli_fetch_array(mysqli_query($dbc, $sql_count_row));
		$row_number = $row_count['row_count'] + 2;
		$sql_update = "insert into bbn_user (email, password, date, row_number) values 
		('$email', '$encrypt_pass', now(), '$row_number')";
		if (mysqli_query($dbc, $sql_update)) {
			setcookie("email", $email, time() + 86400 * 365);
			header('Location: step.php');
		} else {
			echo "Error: ".mysqli_error($dbc);
		}
	}
	mysqli_close($dbc);
	exit;
}
include 'sign-up.html';
?>