<?php
if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirmPass = $_POST['confirm_pass'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$err = "* Invalid email format";
	} 
	elseif (strlen($password) < '6') {
		$err = "* Password must contain at least 6 characters";
	} 
	elseif(!preg_match("#[0-9]+#",$password)) {
		$err = "* Password must contain number!";
	}
	elseif(!preg_match("#[A-Z]+#",$password)) {
		$err = "* Password must contain capital letter";
	}
	elseif(!preg_match("#[a-z]+#",$password)) {
		$err = "* Password must contain lowercase letter";
	} 
	elseif($password != $confirmPass) {
		$err = "* Passwords are not matched";
	}
	else {
		require_once('mysqli_connect.php');
		$query = "select * from bbn_user where email = '$email'";
		$result = @mysqli_query($dbc, $query);
		if (mysqli_num_rows($result) > 0){
			$err = "* Email already exists";
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
	}
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>BeepBeepNation - Token Sale</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap & Jquery -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<link rel="stylesheet" type="text/css" href="jquery.flipcountdown.css" />
<link href="sidemenu.css" rel="stylesheet">
<link href="media-queries.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery.flipcountdown.js"></script>
<script src="https://use.typekit.net/bkt6ydm.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>

<!-- Add sidemenu -->
<script>
(function($){
	// Menu Functions
	$(document).ready(function(){
  	$('#menuToggle').click(function(e){
    	var $parent = $(this).parent('nav');
      $parent.toggleClass("open");
      var navState = $parent.hasClass('open') ? "hide" : "show";
      $(this).attr("title", navState + " navigation");
			// Set the timeout to the animation length in the CSS.
			setTimeout(function(){
				console.log("timeout set");
				$('#menuToggle > span').toggleClass("navClosed").toggleClass("navOpen");
			}, 200);
    	e.preventDefault();
  	});
  });
})(jQuery);

</script>

</head>

<body>

<!------------ Navigation start ------------>
<div id="header">
  <div class="container"> <span class="logo"><a href="#home">
    <a href="index.php"><div id="logo"></div></a>
    </a></span>
    <ul id="menu">
      <!-- <li><a href="">About</a></li> -->
      <li><a href="sign-up.php">Sign Up</a></li>      
      <li><a href="sign-in.php" class="token-btn">Sign In</a></li>
    </ul>
    <nav> 
      <a href="" id="menuToggle" title="show menu"> <span class="navClosed"></span> </a>
      <a href="">About</a>
      <a href="sign-up.php">Sign Up</a>
      <a href="sign-in.php" class="token-btn">Sign In</a>
    </nav>
  </div>
</div>
<!------------ Navigation end ------------>
<!------------ Sign up start ------------>
<section id="signpage" class="signpage">
  <div class="container">
    <div class="signpage-container">
      <h1 style="color:white">Sign Up</h1>
      <div class="h-line h-line-small" style="display:inline-block; background-color:white"></div>
      <form action="sign-up.php" method="post">
        <label id="error2" style="margin-top:10px; margin-bottom:10px; color:red;"><?php if($err) echo $err;?></label>
        <div class="clearfix">
          <input type='email' name="email" class="input-style" placeholder="Email Address" value="<?php if($email) echo $email; ?>" required />
        </div>
        <div class="clearfix">
          <input type='password' name="password" class="input-style" placeholder="Password" style="width: 100%; height: 58px; border:none" required />
        </div>
        <div class="clearfix">
          <input type='password' name="confirm_pass" class="input-style" placeholder="Confirm Password" style="width: 100%; height: 58px; border:none" required />
        </div>
        <br>
        <div style="float:left;"><p style="padding-top:20px" class="highlight-text"><a href="sign-in.php">Have an Account?</a></p></div>
        <div style="float:right">
          <input type="submit" name="submit" class="btn light-btn" value="Register">
        </div>
        <div style="clear:both;"></div>
      </form>
    </div>    
  </div>
</section>
<!------------ Sign up end ------------>
  
<!------------ Footer start ------------> 
<section id="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-3 v-pad">
        <div class="footer-logo"><img src="img/logo.svg" alt=""></div>
      </div>
      <?php include 'socials.html' ?>
      <div class="col-md-4 col-sm-3 v-pad">
        <div class="copyright">
          <span class="small-font">Copyright © 2018 Amazing Appventures Pte. Ltd.</span>
          <br><br>
          
          <!--<span class="small-font">Privacy Policy &nbsp;| &nbsp;Terms of Service</span>-->

        </div>
      </div>
    </div>
  </div>
</section>
<!------------ Footer end ------------>

<script>
$(window).scroll(function() {
  var addRemClass = $(window).scrollTop() > 0 ? 'addClass' : 'removeClass';
    $("#header")[addRemClass]('bgChange');
});

</script> 

<script>
	jQuery(function($){
		//var NY = Math.round((new Date('1/01/2015 00:00:01')).getTime()/1000);
		$('#new_year').flipcountdown({
			size:'md',
			beforeDateTime:'03/24/2018 00:00:01'
			/*tick:function(){
				var nol = function(h){
					return h>9?h:'0'+h;
				}
				var	range  	= NY-Math.round((new Date()).getTime()/1000),
					secday = 86400, sechour = 3600,
					days 	= parseInt(range/secday),
					hours	= parseInt((range%secday)/sechour),
					min		= parseInt(((range%secday)%sechour)/60),
					sec		= ((range%secday)%sechour)%60;
				return nol(days)+' '+nol(hours)+' '+nol(min)+' '+nol(sec);
			}*/
		});
	});
	
</script>

<script>
(function(d){d.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(f,e){d.fx.step[e]=function(g){if(!g.colorInit){g.start=c(g.elem,e);g.end=b(g.end);g.colorInit=true}g.elem.style[e]="rgb("+[Math.max(Math.min(parseInt((g.pos*(g.end[0]-g.start[0]))+g.start[0]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[1]-g.start[1]))+g.start[1]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[2]-g.start[2]))+g.start[2]),255),0)].join(",")+")"}});function b(f){var e;if(f&&f.constructor==Array&&f.length==3){return f}if(e=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(f)){return[parseInt(e[1]),parseInt(e[2]),parseInt(e[3])]}if(e=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(f)){return[parseFloat(e[1])*2.55,parseFloat(e[2])*2.55,parseFloat(e[3])*2.55]}if(e=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(f)){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}if(e=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(f)){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}if(e=/rgba\(0, 0, 0, 0\)/.exec(f)){return a.transparent}return a[d.trim(f).toLowerCase()]}function c(g,e){var f;do{f=d.css(g,e);if(f!=""&&f!="transparent"||d.nodeName(g,"body")){break}e="backgroundColor"}while(g=g.parentNode);return b(f)}var a={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]}})(jQuery);
</script>

</body>
</html>
