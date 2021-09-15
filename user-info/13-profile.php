<?php
session_start();
require '../INCLUDES/dbh.inc.php';
require '../INCLUDES/header.php';
$uid = 13;
$id = $uid;
$uEmail = "jpc72075@gmail.com";

 require 'include/profile-permission.inc.php';

 require 'profile-new-ui.inc.php';
 require '../INCLUDES/footer.php';
?>
