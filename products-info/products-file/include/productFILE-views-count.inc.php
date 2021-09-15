<?php
    date_default_timezone_set("Asia/Hong_Kong");
    /*count views of product, and only able for owner*/
    $cv_total_sql = "SELECT count(productID) AS totalviews FROM productrecord WHERE productID = ?";
    $cv_total_stmt = mysqli_stmt_init($conn);

    /*prepare*/
    if (!mysqli_stmt_prepare($cv_total_stmt, $cv_total_sql)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*binding*/
    } else {
      mysqli_stmt_bind_param($cv_total_stmt, "i", $goodsIDp);
      mysqli_stmt_execute($cv_total_stmt);
      $cv_total_result = mysqli_stmt_get_result($cv_total_stmt);
      $cv_total_row = mysqli_fetch_array($cv_total_result);

      $totalViews = $cv_total_row['totalviews'];

      if (!mysqli_stmt_close($cv_total_stmt)) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();

        /*count the views today*/
      } else {

        $today = date("Y-m-d");

        $cv_today_sql = "SELECT count(productID) AS viewstoday FROM productrecord WHERE productID = ? AND recordDate = ?";
        $cv_today_stmt = mysqli_stmt_init($conn);

        /*prepare*/
        if (!mysqli_stmt_prepare($cv_today_stmt, $cv_today_sql)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();

          /*binding*/
        } else {
          mysqli_stmt_bind_param($cv_today_stmt, "is", $goodsIDp, $today);
          mysqli_stmt_execute($cv_today_stmt);
          $cv_today_result = mysqli_stmt_get_result($cv_today_stmt);
          $cv_today_row = mysqli_fetch_array($cv_today_result);

          $viewsToday = $cv_today_row['viewstoday'];

          if ($session !== $userIDp) {
            $totalViews = '';
            $viewsToday = '';

          } else {
            $totalViews = '總點擊量：'.$totalViews;
            $viewsToday = '今日點擊量：'.$viewsToday;
          }
        }
      }
    }
