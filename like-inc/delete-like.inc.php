<?php
    require '../INCLUDES/dbh.inc.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!isset($_POST['email1']) || !isset($_POST['goodsID1'])) {
      header("Location: https://www.gaakzei.com");
      exit();
    } else {
      $email = $_POST['email1'];
      $goodsID = $_POST['goodsID1'];

      $sql = "DELETE FROM goodslike WHERE userEmail=? AND goodsID=?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "si", $email, $goodsID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
      }
    }
