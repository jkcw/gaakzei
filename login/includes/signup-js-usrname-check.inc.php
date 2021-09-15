<?php

require '../../INCLUDES/dbh.inc.php';
require 'user-name-check.inc.php';

$usr_name = $_POST['usr_name'];

$status = check_user_name_available($conn, $usr_name);

if ($status == 0 ) {

    echo 0;

} else {

    echo 1;
}
?>