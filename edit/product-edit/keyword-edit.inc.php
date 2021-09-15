<?php
  session_start();

  require '../../INCLUDES/dbh.inc.php';

  /* Function */
  function sql_uplaod_keyword($conn, $keyword, $sql_para, $uid, $pid) {

    if ($keyword != null) {

      $sql = $sql_para;
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();

      } else {
        mysqli_stmt_bind_param($stmt, "sii", $keyword, $uid, $pid);
        mysqli_stmt_execute($stmt);

        if (!mysqli_stmt_close($stmt)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();

        } else {
          return true;
        }
      }

      /* if no input */
    } else {
      return true;
    }

  }


  if (!isset($_SESSION['usersEmail'])) {
    header("Location: https://www.gaakzei.com/INCLUDES/login");
    exit();
  } elseif (!isset($_POST['ky-button'])) {
    header("Location: https://www.gaakzei.com?error=nsubmit");
    exit();
  } elseif (!isset($_POST['pid-ky']) || !isset($_POST['uid-ky'])) {
    header("Location: https://www.gaakzei.com?error=npid");
    exit();
  } else {
    /*Check identy of user and product*/
    $session = $_SESSION['usersEmail'];
    $pid = $_POST['pid-ky'];
    $uid = $_POST['uid-ky'];

    $checkSQL = "SELECT * FROM keywords WHERE userID=? AND goodsIDky=?;";
    $stmtC = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtC, $checkSQL)) {
      header("Location: https://www.gaakzei.com?error=sql1");
      exit();
    } else {
      mysqli_stmt_bind_param($stmtC, "ii", $uid, $pid);
      mysqli_stmt_execute($stmtC);
      $resultC = mysqli_stmt_get_result($stmtC);
      $num = mysqli_num_rows($resultC);

      if ($num == 0) {
        header("Location: https://www.gaakzei.com?error=sql2");
        exit();
        /*End of checking user identity and product*/
      } else {
        $ky1 = $_POST['ky1'];
        $ky2 = $_POST['ky2'];
        $ky3 = $_POST['ky3'];

        /*Start of updating value*/

        /* Upload the first ky */
        $sql1 = "UPDATE keywords SET keyword1=? WHERE userID=? AND goodsIDky=?;";
        sql_uplaod_keyword($conn, $ky1, $sql1, $uid, $pid);

        /* Upload the second ky */
        $sql2 = "UPDATE keywords SET keyword2=? WHERE userID=? AND goodsIDky=?;";
        sql_uplaod_keyword($conn, $ky2, $sql2, $uid, $pid);

        /* Upload the third ky */
        $sql3 = "UPDATE keywords SET keyword3=? WHERE userID=? AND goodsIDky=?;";
        sql_uplaod_keyword($conn, $ky3, $sql3, $uid, $pid);

        $path = $uid.'-'.$pid;
        header("Location: https://www.gaakzei.com/products-info/products-file/$path?success=key");
        exit();

          }
        }
      }