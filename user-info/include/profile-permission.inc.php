<?php

    $sql = "SELECT uidUsers, userShopN, userPhoneN, userContactEmail, userIG, userFB, userDate, userArticle, usersIcon FROM users WHERE idusers=? AND emailUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: https://www.gaakzei.com?error=pfsqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "is", $uid, $uEmail);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);

      $userName = $row['uidUsers'];
      $userShopN = $row['userShopN'];
      $userPhoneN = $row['userPhoneN'];
      $userContectEmail = $row['userContactEmail'];
      $userIG = $row['userIG'];
      $userFB = $row['userFB'];
      $userDate = $row['userDate'];
      $userArticle = $row['userArticle'];
      $userIcon = $row['usersIcon'];

      $userDate_array = explode(" ", $userDate);
      $user_join_date = $userDate_array[0];
    }
    if (isset($_SESSION['usersEmail'])) {
      $session = $_SESSION['usersEmail'];

      if ($session == $uEmail) {
        $edit_button = '<div class="profile-details-button-div">
                          <div class="each-edit-button-div">
                            <form action="https://www.gaakzei.com/edit/profile-edit/profile-edit">
                              <button class="button-edit" type="submit">編輯</button>
                            </form>
                          </div>
                          <div class="each-edit-button-div">
                            <form action="https://www.gaakzei.com/edit/refill/refill">
                              <button class="button-refill" type="submit">極速補貨系統</button>
                            </form>
                          </div>
                        </div>';
      } else {
        $edit_button = '';
      }
    } else {
      $edit_button = '';
    }

    mysqli_stmt_close($stmt);

/*======================================================================*/

    /*Find out amount of followers*/

    $sql_f = "SELECT * FROM follow WHERE ownerID=?";
    $stmt_f = mysqli_stmt_init($conn);

    /*Prepare*/
    if (!mysqli_stmt_prepare($stmt_f , $sql_f)) {
      header("Location: https://www.gaakzei.com?error=pfsqlerror");
      exit();

      /*Binding*/
    } else {
      mysqli_stmt_bind_param($stmt_f, "i", $uid);
      mysqli_stmt_execute($stmt_f);
      $result_f = mysqli_stmt_get_result($stmt_f);
      $num_f = mysqli_num_rows($result_f);

      /*Close*/
      if (!mysqli_stmt_close($stmt_f)) {
        header("Location: https://www.gaakzei.com?error=pfsqlerror");
        exit();

/*======================================================================*/

      /*Find out amount of products*/
      } else {

        $sql_p = "SELECT * FROM goodsinfo WHERE goodsUserID=?";
        $stmt_p = mysqli_stmt_init($conn);

        /*Prepare*/
        if (!mysqli_stmt_prepare($stmt_p, $sql_p)) {
          header("Location: https://www.gaakzei.com?error=pfsqlerror");
          exit();

          /*Binding*/
        } else {
          mysqli_stmt_bind_param($stmt_p, "i", $uid);
          mysqli_stmt_execute($stmt_p);
          $result_p = mysqli_stmt_get_result($stmt_p);
          $num_p = mysqli_num_rows($result_p);

          mysqli_stmt_close($stmt_p);
        }
      }
    }


 ?>
