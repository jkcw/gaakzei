<?php

    function security() {

      date_default_timezone_set("Asia/Hong_Kong");

      $date = date("Y-m-d");
      $time = date("H:i:s");

      require '../../INCLUDES/dbh.inc.php';
/*------------------------------------------------------*/

      if (isset($_SESSION['uid'])) {
        $uid = $_SESSION['uid'];

      } else {

        $uid = "";
      }

/*------------------------------------------------------*/

      if (isset($_SERVER['HTTP_REFERER'])) {
        $referral = $_SERVER['HTTP_REFERER'];
      } else {
        $referral = "";
      }

/*------------------------------------------------------*/

      if (isset($_SERVER["QUERY_STRING"])) {
        $query = $_SERVER["QUERY_STRING"];
      } else {
        $query = "";
      }

      $file = $_SERVER['PHP_SELF'];
      $ip = $_SERVER['REMOTE_ADDR'];

      $sql = "INSERT INTO view (userID, recordDate, recordTime, referral, query, file, ip) VALUES (?,?,?,?,?,?,?);";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com/INCLUDES/index.php?error=sql");
        exit();

      } else {
        mysqli_stmt_bind_param($stmt, "issssss", $uid, $date, $time, $referral, $query, $file, $ip);
        mysqli_stmt_execute($stmt);
      }
    }
