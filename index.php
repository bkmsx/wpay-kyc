<?php
/*affiliate id tracking*/
/*parse url and get the last entry in the url*/
// if($_GET["utm_source"] && $_GET["click_id"])
//     {
//     setcookie("utm_source", $_GET["utm_source"], time()+(3600*24*999), "/", ".beepbeepnation.com");
//     setcookie("click_id", $_GET["click_id"], time()+(3600*24*999), "/", ".beepbeepnation.com");
//     }
    
// $nurl = rtrim($_SERVER['REQUEST_URI'], '/');
// $lastchar = substr( $nurl, strrpos( $nurl, '/' )+1 );
// if($lastchar == 'x')
//     {
//     unset($_COOKIE["af_id"]);
//     $url = parse_url($_SERVER['REQUEST_URI']);
//     setcookie("af_id", "X", time()-(3600*24), "/", ".beepbeepnation.com");
//     $nurl = strtolower(rtrim(str_replace("%2F", "/", $url["path"]), "/"));
//     $nurl = rtrim($nurl, "x");
//     header("location: $nurl");
//     exit();
//     }
// else
//     {
//     $url = parse_url($_SERVER['REQUEST_URI']);
//     if($url["path"] != NULL)
//         {
//         $nurl = strtolower(rtrim(str_replace("%2F", "/", $url["path"]), "/"));
//         $url = explode("/", $nurl);
//         if(is_array($url))
//             {
//             $afid = $url[count($url)-1];
//             if($afid)
//                 {
//                 if(preg_match("/^x[a-z0-9]/", $afid))
//                     {
//                 $dbhost = "localhost";
//                 $dbuser = "makeacha_root";
//                 $dbpass = "@q1w2e3r4@";
//                 $dbname = "makeacha_lcxapp";
//                 $connection = mysql_connect($dbhost,$dbuser,$dbpass)
//                     or die ("Couldn't connect to server");
//                 $db = mysql_select_db($dbname)
//                     or die ("Couldn't select database");
                    
//                 $result = mysql_query("SELECT * FROM link_exceptions WHERE link_exception_text = '$afid'");
//                 if(mysql_num_rows($result) == 0)
//                     {
//                         $afid = strtolower($afid);
//                         $afid = ltrim($afid, "x");
//                         $nurl = rtrim($nurl, "x$afid");
                        
//                         $aftype = 0;
//                         $result = mysql_query("SELECT * FROM xperiences_affiliates WHERE affiliate_number='$afid'");
//                         if($row=mysql_fetch_array($result))
//                             {
//                             $afid=$row["affiliate_number"];
//                             $affiliate_id=$row["affiliate_id"];
//                             $aftype=$row["affiliate_type"];
                            
//                             $ipaddress = '';
//                             if (getenv('HTTP_CLIENT_IP'))
//                                 $ipaddress = getenv('HTTP_CLIENT_IP');
//                             else if(getenv('HTTP_X_FORWARDED_FOR'))
//                                 $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
//                             else if(getenv('HTTP_X_FORWARDED'))
//                                 $ipaddress = getenv('HTTP_X_FORWARDED');
//                             else if(getenv('HTTP_FORWARDED_FOR'))
//                                 $ipaddress = getenv('HTTP_FORWARDED_FOR');
//                             else if(getenv('HTTP_FORWARDED'))
//                                 $ipaddress = getenv('HTTP_FORWARDED');
//                             else if(getenv('REMOTE_ADDR'))
//                                 $ipaddress = getenv('REMOTE_ADDR');
//                             else
//                                 $ipaddress = 'UNKNOWN';
                                
//                             $datetoday = date("Y-m-d");
//                             $result = mysql_query("SELECT * FROM affiliate_clicks WHERE click_date='$datetoday' AND user_ip='$ipaddress' AND server_uri='$nurl' AND affiliate_id=$affiliate_id AND server_source='beepbeepnation.com'");
//                             if(mysql_num_rows($result) == 0)
//                                 $result = mysql_query("INSERT INTO affiliate_clicks (click_date, user_ip, server_uri, affiliate_id, server_source) VALUES ('$datetoday', '$ipaddress', '$nurl', '$affiliate_id', 'beepbeepnation.com')");
//                             }
//                         else
//                             $afid=0;
//                         $prevafid="";
//                         $prevnafid="";
//                         if($_COOKIE["af_id"])
//                             $prevafid = $_COOKIE["af_id"];
//                         if($_COOKIE["naf_id"])
// $prevnafid = $_COOKIE["naf_id"];
                            
//                         if($aftype==0)
//                             {
//                             if($prevafid != "" && $prevafid != $afid)
//                                 setcookie("af_id2", $prevafid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("af_id", $afid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("laf_id", $afid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("utm_source", "bbn", time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("click_id", $afid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             }
//                         elseif($aftype==1)
//                             {
//                             if($prevnafid != "" && $prevnafid != $afid)
//                                 setcookie("naf_id2", $prevnafid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("naf_id", $afid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("laf_id", $afid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("utm_source", "bbn", time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             setcookie("click_id", $afid, time()+(3600*24*999), "/", ".beepbeepnation.com");
//                             }
                            
                            
//                         mysql_close();
                        
//                         header("location: $nurl");
//                         exit();    
//                         }
//                     }
//                 }
//             }
//         }
//     }
/*end affiliate tracking*/

  if (!isset($_COOKIE['email']) || isset($_COOKIE['email']) && $_COOKIE['email'] == "") {
    header('Location: sign-in.php');
    exit;
  }

  if (!isset($_COOKIE['kyc_done']) || isset($_COOKIE['kyc_done']) && $_COOKIE['kyc_done'] == "") {
    header('Location: step.php');
    exit;
  }

  $user_email = $_COOKIE['email'];
  $user_email = str_replace("%40", "@", $user_email);
  require_once("mysqli_connect.php");
  
  //fetch user information
  $user_sql = "select * from users where email = '$user_email'";
  $user_result = mysqli_query($dbc, $user_sql);
  $user = mysqli_fetch_array($user_result);
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>BeepBeepNation - Dashboard</title>
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
<link rel="stylesheet" type="text/css" href="jquery.flipcountdown.css"/>
<link href="sidemenu.css" rel="stylesheet">
<link href="magnific-popup.css" rel="stylesheet">
<link href="media-queries.css" rel="stylesheet">
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/utilities.js"></script>
<!-- Start of token Zendesk Widget script -->
<script>/*<![CDATA[*/window.zE||(function(e,t,s){var n=window.zE=window.zEmbed=function(){n._.push(arguments)}, a=n.s=e.createElement(t),r=e.getElementsByTagName(t)[0];n.set=function(e){ n.set._.push(e)},n._=[],n.set._=[],a.async=true,a.setAttribute("charset","utf-8"), a.src="https://static.zdassets.com/ekr/asset_composer.js?key="+s, n.t=+new Date,a.type="text/javascript",r.parentNode.insertBefore(a,r)})(document,"script","aace7492-2999-420e-89fd-ec853f818169");/*]]>*/</script>
<!-- End of token Zendesk Widget script -->

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
    var name = getCookie('email').split('%');
    document.getElementById("greeting").innerHTML = "Hi, " + name[0];
  });
})(jQuery);

function getCookie(key) {
  var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
  return keyValue ? keyValue[2] : null;
}

function purchase() {
  form = document.getElementById("form_amount");
  form.submit();
}

function changeFile(){
    document.getElementById("submitBtn").disabled = false;
}

function uploadPassport(e){
  e.preventDefault();
  var form = $('#upload_form')[0];
  var formData = new FormData(form);
  $('.loading').show();
  $.ajax({
       url:  'upload-passport.php',
       type: 'POST',
       data: formData,
       contentType: false,
       cache: false,
       processData: false,
       success: function (result) {
         console.log(result);
        $('#upload_photo').hide();
        $('#success_label').show();
        $('.loading').hide();
       }
});
}
</script>
</head>

<body>
<div class="loading" hidden>Loading&#8230;</div>
<!------------ Navigation start ------------>
<div id="header">
  <div class="container"> <span class="logo"><a href="#home">
    <a href="index.php"><div id="logo"></div></a>
    </a></span>
    <ul id="menu">
      <li id="greeting">Hi, John</li>      
      <li><a onclick="logOut()" class="token-btn">Log out</a></li>
    </ul>
    <nav> 
      <a href="" id="menuToggle" title="show menu"> <span class="navClosed"></span> </a>
      <a href="index.html" class="token-btn">Log out</a>
      <a href="">Hi, John</a>
    </nav>
  </div>
</div>
<!------------ Navigation end ------------>

<div class="setting-banner" style="text-align:center;">
  <div class="container">
    <h1>Dashboard</h1>
    <div class="h-line" style="display:inline-block;"></div>
  </div>
</div>

<div id="settings">
  <div class="container">
    <div class="settings-container">
      <div class="row">
        <div class="col-md-3 col-sm-3 v-pad purchase-text">
          <!-- <p>Purchase Amount:</p> -->
        </div>
        <form action="payment.php" method="POST" id="form_amount">
          
          <div class="col-md-12 col-sm-12 v-pad">
            <!-- <input type="number" name="token_amount" value="400" min="400" id="token_amount"> -->
            <table  class="table-head">
            <tr valign="center">
              <th>Price (in USD)</th>
              <th>Number of tokens not including bonus tokens</th>
            </tr>
            <?php
              $token_array = [
                "USD100" =>                "400",
                "USD500" =>                "2,000",
                "USD1,000" =>             "4,000",
                "USD5,000" =>             "20,000",
                "USD10,000" =>            "40,000",
                "USD50,000" =>            "200,000",
                "USD100,000" =>          "400,000"
              ];
              foreach($token_array as $key => $value) {
                echo "<tr><td>".$key."</td><td>".$value."</td></tr>";
              }
            ?>
          </table>
          </div>
          <div class="col-md-3 col-sm-3 v-pad purchase-text">
            <p>Your Wallet Address:</p>
          </div>
          <div class="col-md-9 col-sm-9 v-pad">
            <input type="text" name="address" class="input-style wallet-address" value="<?php echo $_COOKIE['wallet_address'] ?>" id="myInput" readonly>
            <button onclick="myFunction()" class="btn-copy"><i class="fa fa-copy" aria-hidden="true"></i></button>
            <div style="clear:both;"></div>
          </div>
        </form>
        <label id="error_lbl" style="color: red" <?php if($user['status'] == "CLEARED") echo "hidden";?> >*Your account has not been approved yet</label>
        <div class="col-md-12 col-sm-12 v-pad">
          <button id="purchase_btn" onclick="purchase()" class="btn light-btn" <?php if($user['status'] != "CLEARED") echo "disabled";?>>Purchase</button>
        </div>
      </div>
      <br>
      <br>
      <span class="small-font">If you would like to change the destination wallet, please send an email to <a href="mailto:admin@amazingappventures.ltd" class="highlight-text">admin@amazingappventures.ltd</a></span>
    </div>

    
    <!-- Upload photo -->
    <div id="success_label" hidden> 
      <br/><br/><br/><br/><br/>
      <label id="" style="color:green" >You uploaded passport successfully!</label>
    </div>
    <div id="upload_photo" <?php if($user['passport_location'] != null) echo "hidden"; ?> >
      <br/><br/><br/><br/><br/>
      <div style="text-align:center;">
        <h2 style="color:white">Identity Image</h1><div class="h-line" style="display:inline-block;"></div>
      </div>
      <br>
      <label style="color:red"> <?php if(isset($err)) echo $err;?></label>
      <form id="upload_form">
        <div >
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
        <input type="hidden" name="email" value="<?php echo $user['email'];?>">
      </form>
      <div style="overflow:auto;">
        <div style="text-align:center;">
          <button id="submitBtn" type="button" name="submit" class="btn light-btn" onclick="uploadPassport(event)" disabled>Submit</button>
        </div>
        </div>
    </div>
    <!--  Transaction history-->
    <div style="background:#004d3f1f; height:1px; width:100%; margin:60px 0;"></div>
    <h2 style="font-weight:700;">Transaction History</h2>
    <div class="h-line" style="display:inline-block;"></div>
    <br>
    <br>
    <div style="overflow-x:auto;">
    <table>
            <tr valign="center">
              <th>DATE</th>
              <th>CURRENCY</th>
              <th>AMOUNT</th>
              <th>WGP AMOUNT</th>
              <th>WGP BONUS</th>
              <th>Total WGP</th>
              <th>CONVERSION RATE</th>
              <th>STATUS</th>
            </tr>
          <?php 
            $transaction_history_sql = "select * from transactions where user_email = '$user_email' order by date desc";
            $result = mysqli_query($dbc, $transaction_history_sql);
            while ($transaction = mysqli_fetch_array($result)){
              echo "<tr>";
              echo "<td>".$transaction['date']."</td>";
              echo "<td>".$transaction['currency']."</td>";
              echo "<td>".$transaction['amount']."</td>";
              echo "<td>".$transaction['token_amount']."</td>";
              echo "<td>".$transaction['token_bonus']."</td>";
              echo "<td>".$user['token_number']."</td>";
              echo "<td>".$transaction['conversion_rate']."</td>";
              echo "<td>".$transaction['status']."</td>";
              echo "</tr>";
            }
            mysqli_close($dbc);
          ?>          
          </table>
    </div>
  </div>
</div>

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
          
          <span class="small-font"><a href="#privacy" class="open-popup-link highlight-text">Privacy Policy</a></span>

        </div>
      </div>
    </div>
  </div>
</section>
<!------------ Footer end ------------>

<!---------- Privacy policy popup ------------>
<div id="privacy" class="white-popup mfp-hide sans">
  <h2>Privacy Policy</h2>
  <br>
  <br>
  <p>By submitting your personal information to us, you consent to such information being used by us for the provision of the Services and also for us to communicate with you. </p>
  <br>
  <p>In the event if you do not agree for Beep Beep Nation to process your data, please notify Beep Beep Nation via email at <a class="highlight-text" href="mailto:admin@amazingappventures.ltd">admin@amazingappventures.ltd.</a></p>
</div>
<!---------- Privacy policy popup END ------------> 

<script>
$(window).scroll(function() {
  var addRemClass = $(window).scrollTop() > 0 ? 'addClass' : 'removeClass';
    $("#header")[addRemClass]('bgChange');
});

</script>

<script>
function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  document.execCommand("Copy");
  alert("Copied the text: " + copyText.value);
}
</script>

<script>
  $(document).ready(function() {
    $("#datepicker").datepicker();
  });
  </script>
  
 <script>
    $(document).ready(function () {
        $('.open-popup-link').magnificPopup({
  type:'inline',
  midClick: true,
  mainClass: 'mfp-fade' // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
  
});
		
    });
</script>

<script>
(function(d){d.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(f,e){d.fx.step[e]=function(g){if(!g.colorInit){g.start=c(g.elem,e);g.end=b(g.end);g.colorInit=true}g.elem.style[e]="rgb("+[Math.max(Math.min(parseInt((g.pos*(g.end[0]-g.start[0]))+g.start[0]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[1]-g.start[1]))+g.start[1]),255),0),Math.max(Math.min(parseInt((g.pos*(g.end[2]-g.start[2]))+g.start[2]),255),0)].join(",")+")"}});function b(f){var e;if(f&&f.constructor==Array&&f.length==3){return f}if(e=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(f)){return[parseInt(e[1]),parseInt(e[2]),parseInt(e[3])]}if(e=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(f)){return[parseFloat(e[1])*2.55,parseFloat(e[2])*2.55,parseFloat(e[3])*2.55]}if(e=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(f)){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}if(e=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(f)){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}if(e=/rgba\(0, 0, 0, 0\)/.exec(f)){return a.transparent}return a[d.trim(f).toLowerCase()]}function c(g,e){var f;do{f=d.css(g,e);if(f!=""&&f!="transparent"||d.nodeName(g,"body")){break}e="backgroundColor"}while(g=g.parentNode);return b(f)}var a={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0],transparent:[255,255,255]}})(jQuery);
</script>

</body>
</html>
