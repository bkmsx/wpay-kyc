<?php
if (empty($_COOKIE['email'])) {
	header('Location: sign-in.php');
	exit;
}
if(isset($_FILES['file']) || !empty($_POST['fname']) || !empty($_POST['lname']) || 
	!empty($_POST['date_of_birth']) || !empty($_POST['citizenship'])){
	// save information for retry
	setcookie("first_name", $_POST['fname'], time() + 86400 * 365);
	setcookie("last_name", $_POST['lname'], time() + 86400 * 365);
	setcookie("date_of_birth", $_POST['date_of_birth'], time() + 86400 * 365);
	setcookie("citizenship", $_POST['citizenship'], time() + 86400 * 365);
	setcookie("country", $_POST['country'], time() + 86400 * 365);
	setcookie("wallet_address", $_POST['wallet_address'], time() + 86400 * 365);

	require_once('mysqli_connect.php');
	// check if wallet address exists
	$sql_check_walletaddress = "select * from users where wallet_address = '".$_POST['wallet_address']."'";
	$result_walletaddress = mysqli_query($dbc, $sql_check_walletaddress);
	if (mysqli_num_rows($result_walletaddress) > 0) {
		$err = "This Wallet Address was registered in our system. Please use another Wallet Address!";
		setcookie('error', 'address', time() + 86400 * 1);
		include 'error_page.php';
		exit;
	}

	

	// send kyc submission mail
	require_once('send-mail.php');
	sendMail($_COOKIE['email'], getApplyKycTitle(), getApplyKycMessage($_POST['lname']));

	// check Artemis
	$sql_max_id = "select * from users where email='".$_COOKIE['email']."'";
	$result = mysqli_query($dbc, $sql_max_id);
	$user = mysqli_fetch_array($result);

	require_once('request_api.php');
	$url = "https://p3.cynopsis.co/artemis_novumcapital/default/individual_risk";
	$fname = empty($_POST['fname'])? " " : $_POST['fname'];
	$lname = empty($_POST['lname'])? " " : $_POST['lname'];
	$date_of_birth = empty($_POST['date_of_birth'])? " " : $_POST['date_of_birth'];
	$data = array (
		"rfrID"=>$user['user_id'],
		"first_name"=>$fname,
		"last_name"=>$lname,
		"date_of_birth"=>$date_of_birth,
		"nationality"=>$_POST['citizenship'],
		"country_of_residence"=>$_POST['country'],
		"ssic_code"=>"UNKNOWN",
		"ssoc_code"=>"UNKNOWN",
		"onboarding_mode"=>"NON FACE-TO-FACE",
		"payment_mode"=>"UNKNOWN",
		"product_service_complexity"=>"COMPLEX",
		"emails"=>[$_COOKIE['email']],
		"domain_name"=>"NOVUMCAPITAL"
	);

	$header = ['Content-Type: application/json', 'WEB2PY-USER-TOKEN:03a7a6cb-63b2-47b2-8715-af65aabf28ed'];
	$result = callAPI("POST", $url, $data, $header);
	
	$status = "PENDING";
	$data = json_decode($result);
	if ($data) {
		if (isset($data->approval_status)) {
			$status = $data->approval_status;
		}	
	}
	if ($status == "CLEARED") {
		sendMail($_COOKIE['email'], getSuccessKycTitle(), getSuccessKycMessage($_POST['lname'], $_POST['wallet_address']));
	}

	// Update Google sheet
	require_once('update-sheet.php');
	updateSheet([$_COOKIE['email'], $fname." ".$lname, $date_of_birth, $_POST['citizenship'], $_POST['country'], date('d/m/Y h:i:s', time()), $status, $_POST['wallet_address']], $user['row_number']);

	// Update database
	$sql = "update users set first_name='"
	.$_POST['fname']."', last_name='"
	.$_POST['lname']."', date_birth='"
	.$_POST['date_of_birth']."', citizenship='"
	.$_POST['citizenship']."',country='"
	.$_POST['country']."', date=now(), status='"
	.$status."', wallet_address='"
	.$_POST['wallet_address'];
	
	if(isset($_FILES['file']) && !empty($name) && !empty($tmp_name)) {
		$sql = $sql."', passport_location='".$location;
	}

	$sql = $sql."' where email='".$_COOKIE['email']."'";
	if(mysqli_query($dbc, $sql)){
		setcookie("wallet_address", $_POST['wallet_address'], time() + 86400 * 365);
		setcookie("last_name", $_POST['lname'], time() + 86400 * 365);
		setcookie("error", "", time() + 86400 * 365);
		setcookie("kyc_done", 'true', time() + 86400 * 365);	
	} else {
		$err = "System error. Please retry or contact us about the problem at email: <a href='mailto:admin@amazingappventures.ltd'>admin@amazingappventures.ltd</a>";
		include 'error_page.php';
		exit;
	}

}

require_once('mysqli_connect.php');
$sql = "select * from nationality";
$result = mysqli_query($dbc, $sql);
$nations = array();
while ($nation = mysqli_fetch_array($result)) {
	array_push($nations, $nation);
}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>BeepBeepNation - Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap & Jquery -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<link rel="stylesheet" type="text/css" href="jquery.flipcountdown.css" />
<link href="sidemenu.css" rel="stylesheet">
<link href="media-queries.css" rel="stylesheet">
<script src="js/utilities.js"></script>
<!-- Add sidemenu -->
<script>
    var citizenship;
    var country;
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
    var name = getCookie('email').split('%');
    document.getElementById("greeting").innerHTML = "Hi, " + name[0];
    $('#submitBtn').attr('disabled', 'disabled');
    $('#nextBtn2').attr('disabled', 'disabled');
    var firstName = getCookie('first_name');
    if (firstName) {
      $('#fname').val(firstName);
    }
    var lastName = getCookie('last_name');
    if (lastName) {
      $('#lname').val(lastName);
    }
    var dateBirth = getCookie('date_of_birth');
    if (dateBirth) {
      $('#date').val(dateBirth.replace(/%2F/g, "/"));
    }
    var walletAddress = getCookie('wallet_address');
    if (walletAddress) {
      $('#wallet_address').val(walletAddress);
    }
    handleInput();
  });
})(jQuery);

function handleClickCheckbox() {
    var checkbox1 = document.getElementById("term1");
    var checkbox2 = document.getElementById("term2");
    var button = document.getElementById("nextBtn");
    if (checkbox1.checked && checkbox2.checked){
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}

function handleInput() {
    var firstName = $('#fname').val();
    var lastName = $('#lname').val();
    var walletAddress = $('#wallet_address').val();
    var date = $('#date').val();
    var regexName = /^[A-Za-z ]+$/;
    var nameIsOk = regexName.test(firstName) && regexName.test(lastName);
    if (firstName && lastName && !nameIsOk) {
      $('#errorName').html('* Name only contains characters and space');
    } else {
      $('#errorName').html('');
    }  
    var regexAddr = /^0x[a-fA-F0-9]{40}$/;
    var addressIsOk = regexAddr.test(walletAddress);
    if (walletAddress && !addressIsOk) {
      $('#errorAddr').html('* Address is not Ethereum address');
    } else {
      $('#errorAddr').html('');
    }
    if (firstName == '' || lastName == '' || walletAddress == '' || date == '' || !nameIsOk || !addressIsOk) {
        $('#nextBtn2').attr('disabled', 'disabled');
    } else {
        $('#nextBtn2').removeAttr('disabled');
    }
}

function checkDate(){
    var regex = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/g;
    var date = $('#date').val();
    if (regex.test(date)){
        handleInput();
        $('#errorDate').html('');
    } else {
        $('#errorDate').html('* Date format: DD/MM/YYYY');
    }
}

function changeFile(){
    document.getElementById("submitBtn").disabled = false;
}

</script>

</style>
</head>

<body>

<!------------ Navigation start ------------>
<div id="header">
  <div class="container"> <span class="logo"><a href="#home">
    <a href="index.php"><div id="logo"></div></a>
    </a></span>
    <ul id="menu" style="margin-top: 15px;">
      <!-- <li><a href="#">About</a></li> -->
      <li id="greeting">Hi, John</li>      
      <li><input type="button" onclick="logOut()" class="token-btn" value = "Log out"></li>
    </ul>
    <nav> 
      <a href="" id="menuToggle" title="show menu"> <span class="navClosed"></span> </a>
      <a href="index.html" class="token-btn">Log out</a>
      <a href="">Hi, John</a>
      <a href="">About</a>
    </nav>
  </div>
</div>
<!------------ Navigation end ------------>


<div class="step-bg1">
<!-- Circles which indicates the steps of the form: -->
 <div class="container">
  <div class="step-container">
    <div class="step"></div>
    <div class="step-line"></div>
    <div class="step"></div>
    <div class="step-line"></div>
    <div class="step"></div>
    <div style="clear:both;"></div>
  </div>
  <br><br>
  <div class="step-title">
    <div class="terms"><h3>Terms & Conditions</h3></div>
    <div class="basic-info"><h3>Basic Information</h3></div>
    <div class="identity"><h3>Completion</h3></div>
    <div style="clear:both;"></div>
  </div>
 </div>
</div>

<section id="step" class="step-bg2">
<div class="container">
<form id="regForm" action="step.php" method="post" enctype="multipart/form-data" style="width: 850px">
  <!-- One "tab" for each step in the form: -->
  <!-- Terms Condition-->
  <div  class="tab" hidden>
    <div style="text-align:center;">
      <h1>Terms & Conditions</h1><div class="h-line" style="display:inline-block;"></div>
    </div>
    <br/>
    <div class="clearfix">
      <table>
        <tr valign="top">
          <td class="radio-btn"><input type="checkbox" id="term1" onclick="handleClickCheckbox()" value="value1" oninput="this.className = ''"></td>
          <td style="padding-bottom: 30px; font-size: 17px; line-height: 22px">I have read the <a href="terms-conditions.html" target="_blank" class="highlight-text"><b>Token Sale Terms & Conditions</b></a>, Privacy Policy and Eminent White Paper, and accept all terms, conditions, obligations, affirmations, representations and warranties outlined in these documents and agree to adhere to them and be legally bound by them.</td>
        </tr>
        <tr valign="top">
          <td class="radio-btn"><input type="checkbox" id="term2" onclick="handleClickCheckbox()" value="value2" oninput="this.className = ''"></td>
          <td style="padding-bottom: 30px;font-size: 17px; line-height: 22px">I confirm that I am not citizen, permanent resident, or granted indefinite leave to remain in the United States or any jurisdiction in which the purchase of Eminent tokens (EMN) is explicitly prohibited or outlawed.</td>
        </tr>
      </table>
    </div>
    
    <br>
    <br>
    <div style="overflow:auto;">
    <div style="text-align:center;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)" disabled>Next</button>
    </div>
  </div>
  </div>

  <!-- Basic information -->
  <div class="tab" hidden>
    <div style="text-align:center;">
      <h1>Basic Information</h1><div class="h-line" style="display:inline-block;"></div>
    </div>
    <br>
    <div id="errorName" style="color: red"></div>
    <div id="errorDate" style="color: red"></div>
    <div id="errorAddr" style="color: red"></div>
    <div class="row">
    <div class="col-md-6 v-pad">
      <label>First Name</label>
      <input id="fname" type="text" class="input-style" placeholder="" name="fname" oninput="handleInput()">
    </div>
    <div class="col-md-6 v-pad">
        <label>Last Name</label>
      <input id="lname" type="text" class="input-style" placeholder="" name="lname" oninput="handleInput()">
    </div>
    <div class="col-md-6 v-pad">
        <label>Date Of Birth</label>
      <input id="date" name="date_of_birth" type='text' id="datepicker" class="input-style calendar"  placeholder="DD/MM/YYYY" value="" oninput="checkDate()"/>
    </div>
    <div class="col-md-6 v-pad">
        <label>Citizenship</label>
      <select id="citizenship" class="input-style" name="citizenship" oninput="this.className = ''">
      <?php
        function cmp($a, $b)
        {
            return strcmp($a['nationality'], $b['nationality']);
        }
        
        usort($nations, "cmp");
				foreach($nations as $nation){
			?>
				<option value="<?php echo $nation['nationality'];?>" <?php if(isset($_COOKIE['citizenship']) && $_COOKIE['citizenship'] == $nation['nationality']) echo 'selected';?>>
					<?php echo $nation['nationality'];?>
				</option>
			<?php } ?>
      </select>
    </div>
    <div class="col-md-6 v-pad">
        <label>Stellar Wallet Address</label>
      <input id="wallet_address" name="wallet_address" class="input-style" type='text'  placeholder="" value=""  oninput="handleInput()"/>
    </div>
    <div class="col-md-6 v-pad">
        <label>Country Of Residency</label>
      <select id="country" class="input-style" name="country" oninput="this.className = ''">
      <?php
        function cmp1($a, $b)
        {
            return strcmp($a['country'], $b['country']);
        }
        usort($nations, "cmp1");
				foreach($nations as $nation){
			?>
				<option value="<?php echo $nation['country'];?>" <?php if(isset($_COOKIE['country']) && $_COOKIE['country'] == $nation['country']) echo 'selected';?>>
					<?php echo $nation['country'];?>
				</option>
			<?php } ?>
      </select>
    </div>
    </div>
    <br>
    <br>
    <div style="overflow:auto;">
    <div style="text-align:center;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      <button type="button" id="nextBtn2" onclick="nextPrev(1)">Submit</button>
    </div>
  </div>
  </div>

  <!-- Upload photo -->
  <!-- <div class="tab" hidden>
    <div style="text-align:center;">
      <h1>Identity Image</h1><div class="h-line" style="display:inline-block;"></div>
    </div>
    <br>
    
    <div class="upload-box">
      <div id="hide">
        <label class="btn upload-btn">
          <input type="file" name="file" onchange="changeFile()" />
          <img src="img/icon-id.png" alt=""> &nbsp;Upload Your Passport
        </label>
      </div>
    </div>
    <br>
    <div style="text-align: center; font-style:italic; font-size:15px; color: rgb(192, 191, 191)">You can only upload file jpg, jpeg, png or pdf and file size less than or equal 4 Mb.</div>
    <br/>
    <br/>
    <br/>
    <div style="overflow:auto;">
    <div style="text-align:center;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <button type="button" id="submitBtn" onclick="nextPrev(1)">Next</button>
    </div>
    </div>
  </div> -->
  <div style="text-align:center; overflow:auto; padding-top:150px;" id="waiting_message" hidden>
    <label>Please do not refresh or navigate away from this page while your details are being submitted...</label>
  </div>
  
  <!-- Thank you form -->
  <div class="tab">
    <div style="text-align:center;">
      <h1>Thank You</h1><div class="h-line" style="display:inline-block;"></div>
    <br>
    <br>
    <i class="fa fa-check-square-o" style="font-size:100px;" aria-hidden="true"></i>
    <br>
    <br>
    <p class="light-text">We are currently processing your application. Please note, we may request that you submit additional identity verification in the future.</p>
    <br>
    <br>
    <br>
    <br>
    <a href="index.php" class="btn light-btn">Go To Dashboard</a>
    </div>
  </div>
  
</form>

</div>
</section>

<!------------ Footer start ------------> 
<section id="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-3 v-pad">
        <div class="footer-logo"><img src="img/logo.svg" alt=""></div>
      </div>
      <?php include 'socials.html'; ?>
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
var currentTab = 0; // Current tab is set to be the first tab (0)
if (getCookie('error') == 'address') {
	var x = document.getElementsByClassName('tab'); 
	x[0].style.display = 'none';
	currentTab = 1;
} else if (getCookie('error') == 'file') {
	var x = document.getElementsByClassName('tab'); 
	x[0].style.display = 'none';
	currentTab = 2;
} else if (getCookie('kyc_done') == 'true') {
	var x = document.getElementsByClassName('tab'); 
	x[0].style.display = 'none';
	currentTab = 2;
}
showTab(currentTab); // Display the crurrent tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n);
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length - 1) {
    // ... the form gets submitted:
    document.getElementById("regForm").submit();
    $("#waiting_message").removeAttr('hidden');
  } else {
    showTab(currentTab);
  }
  // Otherwise, display the correct tab:
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  // alert(n + " : " + x.length);
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
    if(i < n) {
        x[i].className += " finish";
    }
    
  }
  //... and adds the "active" class on the current step:
  if (n < x.length) {
    x[n].className += " active";
  }
}
</script>

<script>
$(window).scroll(function() {
  var addRemClass = $(window).scrollTop() > 0 ? 'addClass' : 'removeClass';
    $("#header")[addRemClass]('bgChange');
});

</script> 

<script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
  });
</script>

<script>
(function(d){d.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(f,e){d.fx.step[e]=function(g){if(!g.colorInit){g.start=c(g.elem,e);g.end=b(g.end);g.colorInit=true}g.elem.style[e]="rgb("+[Math.max(Math.min(parseInt((g.pos*(g.end[0]-g.start[0]))+g.start[0]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[1]-g.start[1]))+g.start[1]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[2]-g.start[2]))+g.start[2]),255),0)].join(",")+")"}});function b(f){var e;if(f&&f.constructor==Array&&f.length==3){return f}if(e=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(f)){return[parseInt(e[1]),parseInt(e[2]),parseInt(e[3])]}if(e=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(f)){return[parseFloat(e[1])*2.55,parseFloat(e[2])*2.55,parseFloat(e[3])*2.55]}if(e=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(f)){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}if(e=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(f)){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}if(e=/rgba\(0, 0, 0, 0\)/.exec(f)){return a.transparent}return a[d.trim(f).toLowerCase()]}function c(g,e){var f;do{f=d.css(g,e);if(f!=""&&f!="transparent"||d.nodeName(g,"body")){break}e="backgroundColor"}while(g=g.parentNode);return b(f)}var a={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]}})(jQuery);
</script>

</body>
</html>

<?php mysqli_close($dbc); ?>