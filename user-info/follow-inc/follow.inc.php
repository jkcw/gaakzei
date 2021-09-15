<?php
    date_default_timezone_set("Asia/Hong_Kong");
    require '../../INCLUDES/dbh.inc.php';

    if (!isset($_POST['ownerID']) || !isset($_POST['followerID'])) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*Get the variables*/
    } else {
      $ownerID = $_POST['ownerID'];
      $followerID = $_POST['followerID'];

      $currentTime = date("Y-m-d H:i:s");

      $sql = "INSERT INTO follow (ownerID ,followerID ,followDate) VALUES (?,?,?) ;";
      $stmt = mysqli_stmt_init($conn);

      /*Prepare*/
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();

        /*Binding*/
      } else {
        mysqli_stmt_bind_param($stmt, "iis", $ownerID, $followerID, $currentTime);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }
    }
