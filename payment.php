<?php
require_once('request_api.php');
$url = "https://api.coinmarketcap.com/v2/ticker/512/?convert=BTC";
$result_json = callAPI("GET", $url);
$result = json_decode($result_json);
$btc_price = $result->data->quotes->BTC->price;

$url = "https://api.coinmarketcap.com/v2/ticker/512/?convert=ETH";
$result_json = callAPI("GET", $url);
$result = json_decode($result_json);
$eth_price = $result->data->quotes->ETH->price;
$usd_price = $result->data->quotes->USD->price;
?>
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
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">
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
    countPayment();
  });
})(jQuery);

function getCookie(key) {
  var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
  return keyValue ? keyValue[2] : null;
}
var btc_price = <?php echo ($btc_price) ?>;
var eth_price = <?php echo ($eth_price) ?>;
var usd_price = <?php echo ($usd_price) ?>;
var token_price = 10;
function countPayment(){
  console.log(btc_price);
  $('#conversion_rate').val(20);
  if ($('#xlm').is(':checked')) {
    $('#amount').val($('#token_amount').val() * token_price);
    $('#conversion_rate').val(token_price);
  } else if ($('#btc').is(':checked')) {
    $('#amount').val($('#token_amount').val() * token_price * btc_price);
    $('#conversion_rate').val(token_price * btc_price);
  } else if ($('#eth').is(':checked')) {
    $('#amount').val($('#token_amount').val() * token_price * eth_price);
    $('#conversion_rate').val(token_price * eth_price);
  } else {
    $('#amount').val($('#token_amount').val() * token_price * usd_price);
    $('#conversion_rate').val(token_price * usd_price);
  }
}

function submitSummary(){
  var amount = $('#token_amount').val();
  if( amount < 400) {
    $('#error').html('* Minimum Purchase Amount Is 400 Tokens');
  } else {
    form = document.getElementById("form_payment");
    form.submit();
  } 
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
    <h1>Payment<br>Selection</h1>
    <div class="h-line" style="display:inline-block;"></div>
  </div>
</div>

<div id="settings" class="payment">
  <div class="container">
    <div class="settings-container">
      <div class="row">
        <div id="error" style="color:red"></div>
        <div class="col-md-4 col-sm-4 v-pad purchase-text">
          <p>WGP Token Amount:</p>
        </div>
        <form action="summary.php" method="POST" id="form_payment">
          <div class="col-md-8 col-sm-8 v-pad">
            <input id="token_amount" name="token_amount" type="number" class="input-style" oninput="countPayment()" value="4000">
          </div>
          <div class="col-md-4 col-sm-4 v-pad purchase-text">
            <p>Wallet Authorization:</p>
          </div>
          <div class="col-md-8 col-sm-8 v-pad">
            <input type="text" name="address" class="input-style wallet-address" value="<?php echo $_POST['address'] ?>" id="myInput" readonly>
            <button onclick="myFunction()" class="btn-copy"><i class="fa fa-copy" aria-hidden="true"></i></button>
            <div style="clear:both;"></div>
          </div>
          <div class="col-md-4 col-sm-4 v-pad purchase-text">
            <p>Payment Method:</p>
          </div>
          <div class="col-md-8 col-sm-8 v-pad radio-payment">
            <input id="xlm" type="radio" name="currency" value="XLM" onclick="countPayment()" checked="checked"> &nbsp;&nbsp;XLM<br><br>
            <input id="btc" type="radio" name="currency" value="BTC" onclick="countPayment()"> &nbsp;&nbsp;BTC<br><br>
            <input id="eth" type="radio" name="currency" value="ETH" onclick="countPayment()"> &nbsp;&nbsp;ETH<br><br>
            <input type="radio" name="currency" value="USD" onclick="countPayment()"> &nbsp;&nbsp;USD
          </div>
          <div class="col-md-4 col-sm-4 v-pad purchase-text">
            <p>Payment Amount:</p>
          </div>
          <div class="col-md-8 col-sm-8 v-pad">
            <input id="amount" name="amount" type="text" class="input-style" readonly> 
          </div>
          <input type="hidden" id="conversion_rate" name="conversion_rate" value="<?php echo 0.25 ?>">
        </form>
        <div class="col-md-12 col-sm-12 v-pad">
          <a onclick="submitSummary()" class="btn light-btn">Continue</a>
        </div>
      </div>
      <br>
      <br>
      <span class="small-font">If you would like to change the destination wallet, please send an email to <a href="mailto:admin@amazingappventures.ltd" class="highlight-text">admin@amazingappventures.ltd</a></span>
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
