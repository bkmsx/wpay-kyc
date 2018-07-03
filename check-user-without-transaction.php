<?php
    require_once('mysqli_connect.php');
    require_once('send-mail.php');
    $sql_user = "select * from bbn_user where status='CLEARED' and coin_number = 0";
    $result_user = mysqli_query($dbc, $sql_user);
    while ($user = mysqli_fetch_array($result_user)) {
        $sql_transaction = "select * from bbn_transaction where user_email='".$user['email']."'";
        $result_transaction = mysqli_query($dbc, $sql_transaction);
        if (mysqli_num_rows($result_transaction) == 0) {
            sendMail($user['email'], getUserWithoutTransactionTitle(), getUserWithoutTransactionMessage($user['first_name']));
        }
    }
?>