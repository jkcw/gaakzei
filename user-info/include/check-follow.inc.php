<?php
    /*Get the data from database*/
    /*Check the number of followers*/
    $followers_sql = "SELECT * FROM follow WHERE ownerID=?";
    $followers_stmt = mysqli_stmt_init($conn);

    /*Pepare*/
    if (!mysqli_stmt_prepare($followers_stmt, $followers_sql)) {
      header("Location: https://www.gaakzei.com?error=pfsqlerror");
      exit();

      /*Binding*/
    } else {
      mysqli_stmt_bind_param($followers_stmt, "i", $uid);
      mysqli_stmt_execute($followers_stmt);
      $followers_result = mysqli_stmt_get_result($followers_stmt);
      $num_followers = mysqli_num_rows($followers_result);
      mysqli_stmt_close($followers_stmt);
    }

    /*------------------------------------------------------------------------------------------------------------------------*/

    /*if no session*/
    if (!isset($_SESSION['uid'])) {
    $follow_button = '<button type="button" name="follow" class="follow_button" id="no_session">追蹤</button>
                      <p id="followerID" value=""></p>';

    /*------------------------------------------------------------------------------------------------------------------------*/

    /*Check the follow status of the user*/
    } elseif (isset($_SESSION['uid'])) {
    $session_id = $_SESSION['uid'];

    /*Sql*/
    $f_check_sql = "SELECT * FROM follow WHERE ownerID=? AND followerID=? LIMIT 1;";
    $f_check_stmt = mysqli_stmt_init($conn);

    /*Prepare*/
    if (!mysqli_stmt_prepare($f_check_stmt, $f_check_sql)) {
      header("Location: https://www.gaakzei.com?error=pfsqlerror");
      exit();

      /*Binding*/
    } else {
      mysqli_stmt_bind_param($f_check_stmt, "ii", $uid, $session_id);
      mysqli_stmt_execute($f_check_stmt);
      $f_check_result = mysqli_stmt_get_result($f_check_stmt);
      $f_check_num = mysqli_num_rows($f_check_result);

      /*Start to echo the button*/
      if ($f_check_num == 0) {
        $follow_button = '<button type="button" name="follow" class="follow_button" id="no_follow">追蹤</button>
              <p id="followerID" value="'.$session_id.'"></p>';

      } elseif ($f_check_num == 1) {
        $follow_button = '<button type="button" name="follow" class="follow_button" id="has_follow">追蹤中</button>
              <p id="followerID" value="'.$session_id.'"></p>';
      }
    }
    }
