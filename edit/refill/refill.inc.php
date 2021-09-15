<?php
  require '../../INCLUDES/dbh.inc.php';
  $uid = $_POST['uid'];
  $gid = $_POST['gid'];
  $quantity = $_POST['quantity'];

  $currentTime = date("Y-m-d H:i:s");

  $sql = "UPDATE goodsinfo SET goodsQuantity=? , goodsRefillDate=? WHERE goodsUserID=? AND goodsID=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "isii", $quantity, $currentTime, $uid, $gid);
    mysqli_stmt_execute($stmt);
    if (!mysqli_stmt_close($stmt)) {
      header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
      exit();
    } else {
      echo $quantity;
    }
  }
