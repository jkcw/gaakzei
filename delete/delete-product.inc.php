<?php
    session_start();

    require '../INCLUDES/dbh.inc.php';

    /*Check status and identity*/
    if (!isset($_POST['delete_goodsID']) || !isset($_POST['delete_ownerID']) || !isset($_SESSION['uid']) || !isset($_SESSION['usersEmail'])) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*Start*/
    } else {
      /*Some variables*/
      $goodsID = $_POST['delete_goodsID'];
      $ownerID = $_POST['delete_ownerID'];
      $uid = $_SESSION['uid'];
      $usersEmail = $_SESSION['usersEmail'];

      /*Double check the identity*/
      if ($ownerID != $uid) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();

        /*Change the photo name*/
      } else {

        $img_sql = "SELECT goodsIMG FROM goodsinfo WHERE goodsID=? AND goodsUserID=?";
        $img_stmt = mysqli_stmt_init($conn);

        /*Prepare*/
        if (!mysqli_stmt_prepare($img_stmt, $img_sql)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();

          /*Binding*/
        } else {
          mysqli_stmt_bind_param($img_stmt, "ii", $goodsID, $uid);
          mysqli_stmt_execute($img_stmt);
          $img_result = mysqli_stmt_get_result($img_stmt);
          $img_row = mysqli_fetch_array($img_result);

          $num_img = $img_row['goodsIMG'];

          /*Loop*/
          for ($i=0; $i < $num_img; $i++) {

            $old_path = $goodsID.'-'.$uid.'-'.$i.'.jpg';
            $new_path = 'WFD'.$goodsID.'-'.$uid.'-'.$i.'.jpg';

            rename("../products-info/products-img/$old_path", "../products-info/products-img/$new_path");

            } /*end of loop*/

            /*====================================================================================================*/

                        /*rename the product file*/
                        $old_file = $uid.'-'.$goodsID.'.php';
                        $deleted_file = 'WFD'.$uid.'-'.$goodsID.'.php';
                        rename("../products-info/products-file/$old_file", "../products-info/products-file/$deleted_file");

            /*====================================================================================================*/

          /*Close stmt*/
          if (!mysqli_stmt_close($img_stmt)) {
            header("Location: https://www.gaakzei.com?error=sql");
            exit();

            /*Delete like*/
          } else {

            $like_sql = "UPDATE goodslike SET deleted = 1 WHERE goodsID=?";
            $like_stmt = mysqli_stmt_init($conn);

            /*Prepare*/
            if (!mysqli_stmt_prepare($like_stmt, $like_sql)) {
              header("Location: https://www.gaakzei.com?error=sql");
              exit();

              /*Binding*/
            } else {
              mysqli_stmt_bind_param($like_stmt, "i", $goodsID);
              mysqli_stmt_execute($like_stmt);

              /*Close*/
              if (!mysqli_stmt_close($like_stmt)) {
                header("Location: https://www.gaakzei.com?error=sql");
                exit();

                /*Delete keywords*/
              } else {

                $kw_sql = "DELETE FROM keywords WHERE goodsIDky=? AND userID=?;";
                $kw_stmt = mysqli_stmt_init($conn);

                /*Prepare*/
                if (!mysqli_stmt_prepare($kw_stmt, $kw_sql)) {
                  header("Location: https://www.gaakzei.com?error=sql");
                  exit();

                  /*Binding*/
                } else {
                  mysqli_stmt_bind_param($kw_stmt, "ii", $goodsID, $uid);
                  mysqli_stmt_execute($kw_stmt);

                  /*Close*/
                  if (!mysqli_stmt_close($kw_stmt)) {
                    header("Location: https://www.gaakzei.com?error=sql");
                    exit();

                    /*Delete goods information*/
                  } else {

                    $final_sql = "DELETE FROM goodsinfo WHERE goodsID=? AND goodsUserID=?";
                    $final_stmt = mysqli_stmt_init($conn);

                    /*Prepare*/
                    if (!mysqli_stmt_prepare($final_stmt, $final_sql)) {
                      header("Location: https://www.gaakzei.com?error=sql");
                      exit();

                      /*Binding*/
                    } else {
                      mysqli_stmt_bind_param($final_stmt, "ii", $goodsID, $uid);
                      mysqli_stmt_execute($final_stmt);

                      if (!mysqli_stmt_close($final_stmt)) {
                        header("Location: https://www.gaakzei.com?error=sql");
                        exit();

                        /*Success*/
                      } else {
                        $success_path = $uid.'-profile.php';
                        header("Location: https://www.gaakzei.com/user-info/$success_path?success=delete");
                        exit();
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
