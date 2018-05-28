<?php
DEFINE ('DB_USER', 'makeacha');
DEFINE ('DB_PASSWORD', '!TFRA~h~4A*g');
DEFINE ('DB_HOST', 'server1.makeachange.me');
DEFINE ('DB_NAME', 'makeacha_beepbeepnation');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL '.mysqli_connect_error());

?>