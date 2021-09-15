<?php

require '../../INCLUDES/dbh.inc.php';
require 'user-name-check.inc.php';

$usr_mail = $_POST['mail_st'];

$status = check_email_available($conn, $usr_mail);

if ($status == 0 ) {

    echo 0;

} else {

    echo 1;
}
?>