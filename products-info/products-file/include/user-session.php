<?php

    $sql = "SELECT * FROM goodsinfo WHERE goodsID =? AND goodsUserID =? LIMIT 1;";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $goodsIDp, $userIDp);
    if (!mysqli_stmt_execute($stmt)) {
        header("Location: www.gaakzei.com?error=nopage");
        echo "唔好意思，此頁面不存在";
        exit();
    } else {
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      if ($row == null) {
        echo "唔好意思，此頁面不存在";
        header("Location: www.gaakzei.com?error=nopage");
        exit();

      } else {
        $goodsTitle = $row['goodsTitle'];
        $goodsContent = $row['goodsContent'];
        $goodsAddress = $row['goodsAddress'];

        /* Edit the goods status when the goods policy is darfted */
        $goodsStatus = $row['goodsStatus']; // Edit it later
        /* Edit the goods status when the goods policy is darfted */

        $goodsPrice = $row['goodsPrice'];
        $goodsWeightG = $row['goodsWeightG'];
        $goodsColor = $row['goodsColor'];
        $goodsUploadDate = $row['goodsUploadDate'];
        $goodsRefillDate = $row['goodsRefillDate'];
        $goodsQuantity = $row['goodsQuantity'];
        $goodsPhone = $row['goodsPhone'];
        $imgQuantity = $row['goodsIMG'];//This is thr quantity of product's images, edit later.

        $emailSQL = "SELECT emailUsers ,uidUsers, usersIcon FROM users WHERE idusers=?";
        $stmtE = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtE, $emailSQL)) {
          echo "SQL error";
        } else {
          mysqli_stmt_bind_param($stmtE, "i", $userIDp);
          mysqli_stmt_execute($stmtE);
          $result = mysqli_stmt_get_result($stmtE);
          $emailRow = mysqli_fetch_assoc($result);
          $email = $emailRow['emailUsers'];
          $uidUsers = $emailRow['uidUsers'];
          $icon = $emailRow['usersIcon'];

          /*explode date*/
          $date = explode(' ', $goodsUploadDate);

          /*check icon*/
          if ($icon == 0 || $icon == null) {
            $icon_output = '<img class="user-icon" src="https://www.gaakzei.com/user-info/system-img/default_icon.png">';
          } elseif ($icon == 1) {
            $icon_output = '<img class="user-icon" src="https://www.gaakzei.com/user-info/user-img/'.$userIDp.'-profile.jpg">';
          }
          mysqli_stmt_close($stmtE);
        }
      }
      mysqli_stmt_close($stmt);
    }
