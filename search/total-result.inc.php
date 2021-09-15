<?php
    $total_sql = "SELECT COUNT(*) FROM goodsinfo WHERE goodsID IN ($id_row);";
    $total_stmt = mysqli_stmt_init($conn);

    /*Prepare*/
    if (!mysqli_stmt_prepare($total_stmt, $total_sql)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*Excution*/
    } else {
      mysqli_stmt_execute($total_stmt);
      $total_get_result = mysqli_stmt_get_result($total_stmt);
      $arr = mysqli_fetch_array($total_get_result);
      $number_of_result =  $arr['COUNT(*)'];
    }
