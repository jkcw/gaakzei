<?php

if (!isset($_SESSION['usersEmail'])) {
  header("Location: https://www.gaakzei.com/INCLUDES/header");
  exit();
  /*End of checking button clicked and session*/
} elseif (!isset($_GET['gid'])) {
  header("Location: https://www.gaakzei.com/INCLUDES/header");
  exit();
  /*End of checking the product ID*/
} else {
  $session = $_SESSION['usersEmail'];
  $productID = $_GET['gid'];

  $uidSQL = "SELECT idusers FROM users WHERE emailUsers=?";
  $stmtUID = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmtUID, $uidSQL)) {
    header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
    exit();
  } else {
    mysqli_stmt_bind_param($stmtUID, "s", $session);
    mysqli_stmt_execute($stmtUID);
    $result = mysqli_stmt_get_result($stmtUID);
    $uidROW = mysqli_fetch_assoc($result);

    $uid = $uidROW['idusers'];

    if (!mysqli_stmt_close($stmtUID)) {
      header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
      exit();
    } else {
      $productSQL = "SELECT * FROM goodsinfo WHERE goodsID=? AND goodsUserID=?";
      $stmtP = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmtP, $productSQL)) {
        header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
        exit();
      } else {
        mysqli_stmt_bind_param($stmtP, "ii", $productID, $uid);
        mysqli_stmt_execute($stmtP);
        $resultP = mysqli_stmt_get_result($stmtP);
        $row = mysqli_fetch_assoc($resultP);

        $goodsTitle = $row['goodsTitle'];
        $goodsContent = $row['goodsContent'];
        $goodsAddress = $row['goodsAddress'];
        $goodsPrice = $row['goodsPrice'];
        $goodsWeightG = $row['goodsWeightG'];
        $goodsColor = $row['goodsColor'];
        //$goodsUploadDate = $row['goodsRefillDate'];
        $goodsQuantity = $row['goodsQuantity'];
        $goodsPhone = $row['goodsPhone'];
        $goodsIMG = $row['goodsIMG'];

        if (!mysqli_stmt_close($stmtP)) {
          header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
          exit();
        } else {
          $keywordsSQL = "SELECT keyword1, keyword2, keyword3 FROM keywords WHERE userID=? AND goodsIDky=?";
          $stmtK = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmtK, $keywordsSQL)) {
            header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
            exit();
          } else {
            mysqli_stmt_bind_param($stmtK, "ii", $uid, $productID);
            mysqli_stmt_execute($stmtK);
            $resultK = mysqli_stmt_get_result($stmtK);
            $rowKey = mysqli_fetch_assoc($resultK);

            $ky1 = $rowKey['keyword1'];
            $ky2 = $rowKey['keyword2'];
            $ky3 = $rowKey['keyword3'];

            mysqli_stmt_close($stmtK);


          }
        }
      }
    }
  }
}
