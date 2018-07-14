<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>BeepBeepNation - Payment Selection</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap & Jquery -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/png" href="img/logo.png"/>
<link rel="stylesheet" type="text/css" href="jquery.flipcountdown.css" />
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

function submitForm(){
  form = document.getElementById("form_summary");
  form.submit();
}
</script>

</head>

<body>

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
    <h1>Transaction<br>Summary</h1>
    <div class="h-line" style="display:inline-block;"></div>
  </div>
</div>

<div id="settings" class="transaction">
  <div class="container">
    <div class="settings-container">
      <h2>Please Send</h2>
      <h2 style="color:#EA7C70"><?php echo $_POST['amount']." ".$_POST['currency']?></h2>
      <br>
      <br>
      <div <?php if ($_POST['currency'] == "USD") echo "hidden";?>>
        <h2>Destination Wallet Address</h2>
        <br>
        <img src="img/qr-code.png" alt="">
        <br>
        <br>
        <br>
        <input type="text" class="input-style wallet-address" value="0x29Dda54a0Cd269DeD3225Ab4A064f234177a018C" id="myInput" readonly>
        <button onclick="myFunction()" class="btn-copy"><i class="fa fa-copy" aria-hidden="true"></i></button>
        <div style="clear:both;"></div>
      </div>
      <div <?php if ($_POST['currency'] == "ETH") echo "hidden";?> >
        <h2>Bank account detail</h2><br/>
        <p class="account"><span class="account-title">Name:</span> <span class="account highlight-text"> AMAZING APPVENTURES PTE. LTD.</span></p>
        <p class="account"><span class="account-title">Address:</span> <span class="account highlight-text"> MOX, Level 3, 451 Joo Chiat Road, #03-02 Singapore 427664</span></p>
        <p class="account"><span class="account-title">Account number: </span> <span class="account highlight-text"> 3529528548</span></p>
        <p class="account"><span class="account-title">Swift code:</span> <span class="account highlight-text"> UOVBSGSG</span></p>
        <p class="account"><span class="account-title">Bank name:</span> <span class="account highlight-text"> United Overseas Bank Limited Co. </span></p>
        <p class="account"><span class="account-title">Bank address:</span> <span class="account highlight-text"> 80 Raffles Place UOB Plaza 1 </span></p>
        <p class="account"><span class="account-title">Comments / Notes: </span> <span class="account highlight-text"> <?php echo $_COOKIE['email']; ?> </span></p><br/>
      </div>
      <br>
      <br>
      <h2>You will Receive:</h2>
      <h2 style="color:#EA7C70;"><?php echo $_POST['token_amount'] ?> Eminent Tokens</h2>
      <br>
      <br>
      <p style="color:#fff;">You will receive a confirmation email once the transaction is validated (this may take up to a few hours). We may email you with a request for KYC documents. If we do not receive your documentation, your funds will be returned to your wallet.</p>
      <br>
      <br>
      <br>
      <a onclick="submitForm()" class="btn light-btn">Purchase</a>

      <form action="thankyou.php" method="POST" id="form_summary">
        <input type="hidden" name="address" value="<?php echo $_POST['address'] ?>">
        <input type="hidden" name="token_amount" value="<?php echo $_POST['token_amount'] ?>">
        <input type="hidden" name="amount" value="<?php echo $_POST['amount'] ?>">
        <input type="hidden" name="currency" value="<?php echo $_POST['currency'] ?>">
        <input type="hidden" name="conversion_rate" value="<?php echo $_POST['conversion_rate'] ?>">
      </form>
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
      <?php include 'socials.html';?>
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
  <p>In the event if you do not agree for Beep Beep Nation to process your data, please notify Beep Beep Nation via email at <a class="highlight-text" href="mailto:admin@amazingappventures.ltd">admin@amazingappventures.ltd</a></p>
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
