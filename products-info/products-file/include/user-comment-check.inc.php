<?php
    require '../../../INCLUDES/dbh.inc.php';

    /* Check */
    if ($_POST['goodsID'] == null || $_POST['goodsID'] == null || $_POST['goodsID'] == 0 || $_POST['goodsID'] == 0) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

    } else {
      /*Get the data from ajax*/
      $goodsID = $_POST['goodsID'];
      $uid = $_POST['uid'];

      $sql = "SELECT * FROM comment WHERE CgoodsID=? AND CuserID=? ;";
      $stmt = mysqli_stmt_init($conn);

      /*Check the launch of prepare statement*/
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();

        /*Start binding and execution*/
      } else {
        mysqli_stmt_bind_param($stmt, "ii", $goodsID, $uid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num = mysqli_num_rows($result);

        /*Check did the user comment before*/
        if ($num > 0) {
          echo 1;
          mysqli_stmt_close($stmt);

        } elseif ($num == 0) {
          echo 0;
          mysqli_stmt_close($stmt);

        }
      }
    }
