<?php

    require '../INCLUDES/dbh.inc.php';

    function like_amount($gid) {

      $like_amount_func_sql = "SELECT * FROM goodslike WHERE goodsID=?";
      $like_amount_func_stmt = mysqli_stmt_init($conn);

      /*Prepare*/
      if (!mysqli_stmt_prepare($like_amount_func_stmt, $like_amount_func_sql)) {
        header("Location: https://www.gaakzei.com/INCLUDES/header.php?error=sql");
        exit();

        /*Binding*/
      } else {
        mysqli_stmt_bind_param($like_amount_func_stmt, "i", $gid);
        mysqli_stmt_execute($like_amount_func_stmt);
        $like_amount_func_result = mysqli_stmt_get_result($like_amount_func_stmt);
        $num_of_like = mysqli_num_rows($like_amount_func_result);
      }
    }

    $like_amount = like_amount('127');
    echo $like_amount;
