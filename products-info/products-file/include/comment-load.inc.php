<?php
    date_default_timezone_set("Asia/Hong_Kong");

    $comment_sql = "SELECT * FROM comment WHERE CgoodsID=? ORDER BY primaryKey DESC LIMIT 2";
    $comment_stmt = mysqli_stmt_init($conn);

    /*prepare*/
    if (!mysqli_stmt_prepare($comment_stmt, $comment_sql)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*binding*/
    } else {
      mysqli_stmt_bind_param($comment_stmt, "i", $goodsIDp);
      mysqli_stmt_execute($comment_stmt);

      $comment_result = mysqli_stmt_get_result($comment_stmt);

/*===================================================================================*/
      $comment_output = '';

      /*loop the result*/
      while ($comment_row = mysqli_fetch_array($comment_result)) {
        /*get the value*/
        $commentContent = $comment_row['UserComment'];

        $CuserID = $comment_row['CuserID'];
        $score = $comment_row['Cscore'];
        $imgQuantity = $comment_row['Cimg'];

        /*get the date*/
        $commentDate = strtotime($comment_row['Cdate']);
        $date_now = strtotime(date('Y-m-d H:i:s'));

        $timeDiff = abs($date_now - $commentDate);
        $numberDays = $timeDiff/86400;

        if ($numberDays < 1) {
          $hour = $timeDiff/3600;

          if ($hour < 1) {
            $numberDays = '剛剛';
          } else {
            $numberDays = round($hour);
            $numberDays .= '小時前';
          }

        } else {
          $numberDays = intval($numberDays);
          $numberDays .= '日前';
        }

/*===================================================================================*/

        /*get the username*/
        $user_name_sql = "SELECT uidUsers FROM users WHERE idusers=?";
        $user_name_stmt = mysqli_stmt_init($conn);

        /*prepare*/
        if (!mysqli_stmt_prepare($user_name_stmt, $user_name_sql)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();

          /*binding*/
        } else {
          mysqli_stmt_bind_param($user_name_stmt, "i", $CuserID);
          mysqli_stmt_execute($user_name_stmt);
          $user_name_result = mysqli_stmt_get_result($user_name_stmt);
          $user_name_fetch = mysqli_fetch_assoc($user_name_result);

          $user_name = $user_name_fetch['uidUsers'];
        } /*end of fetching user name*/

/*===================================================================================*/

        /*score icon*/
          if ($score == 100) {
            $score_icon = '<svg class="each-comment-svg" style="fill: rgb(2, 148, 73);" viewBox="0 0 24 24">
                            <path d="M12,17.5C14.33,17.5 16.3,16.04 17.11,14H6.89C7.69,16.04 9.67,17.5 12,17.5M8.5,11A1.5,1.5 0 0,0 10,9.5A1.5,1.5 0 0,0 8.5,8A1.5,1.5 0 0,0 7,9.5A1.5,1.5 0 0,0 8.5,11M15.5,11A1.5,1.5 0 0,0 17,9.5A1.5,1.5 0 0,0 15.5,8A1.5,1.5 0 0,0 14,9.5A1.5,1.5 0 0,0 15.5,11M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                          </svg>';

          } elseif ($score == 80) {
            $score_icon = '<svg class="each-comment-svg" style="fill: rgb(145, 198, 68)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24">
                            <path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" />
                          </svg>';

          } elseif ($score == 50) {
            $score_icon = '<svg class="each-comment-svg" style="fill: rgb(178, 168, 147)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M8.5,11A1.5,1.5 0 0,1 7,9.5A1.5,1.5 0 0,1 8.5,8A1.5,1.5 0 0,1 10,9.5A1.5,1.5 0 0,1 8.5,11M15.5,11A1.5,1.5 0 0,1 14,9.5A1.5,1.5 0 0,1 15.5,8A1.5,1.5 0 0,1 17,9.5A1.5,1.5 0 0,1 15.5,11M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M9,14H15A1,1 0 0,1 16,15A1,1 0 0,1 15,16H9A1,1 0 0,1 8,15A1,1 0 0,1 9,14Z" />
                          </svg>';

          } elseif ($score == 25) {
            $score_icon = '<svg class="each-comment-svg" style="fill: rgb(248, 148, 28)" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24">
                            <path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14Z" />
                          </svg>';

          } elseif ($score == 0) {
            $score_icon = '<svg class="each-comment-svg" style="fill: rgb(247, 26, 38)" viewBox="0 0 24 24">
                            <path d="M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M16.18,7.76L15.12,8.82L14.06,7.76L13,8.82L14.06,9.88L13,10.94L14.06,12L15.12,10.94L16.18,12L17.24,10.94L16.18,9.88L17.24,8.82L16.18,7.76M7.82,12L8.88,10.94L9.94,12L11,10.94L9.94,9.88L11,8.82L9.94,7.76L8.88,8.82L7.82,7.76L6.76,8.82L7.82,9.88L6.76,10.94L7.82,12M12,14C9.67,14 7.69,15.46 6.89,17.5H17.11C16.31,15.46 14.33,14 12,14Z" />
                          </svg>';
          }

/*===================================================================================*/
          $comment_img_output = '';

          /*loop the image quantity*/
          for ($i=0; $i < $imgQuantity; $i++) {
            $comment_img_output .= '<img class="comment-img" alt="'.$commentContent.'" id="'.$i.'" src="comment-img/comment-'.$goodsIDp.'-'.$CuserID.'-'.$i.'.jpg" />';
          }

/*===================================================================================*/

          $comment_output .= '<div class="each-comment-container">
                                <div class="each-comment-title-main-div">

                                  <div class="each-comment-title-sub-div">
                                    <p class="comment-username-p">
                                      <a class="comment-username-a" href="https://www.gaakzei.com/user-info/'.$CuserID.'-profile">'.$user_name.'</a>
                                    <p>
                                  </div>
                                  <div class="each-comment-title-sub-div">
                                    <p class="comment-commentdate-p">'.$numberDays.'<p>
                                  </div>

                                  <a href="https://www.gaakzei.com/customer-service/rating-report?pid='.$goodsIDp.'&uid='.$CuserID.'">
                                    <img class="report-svg" src="https://www.gaakzei.com/products-info/products-file/system-svg/report.svg" alt="gaakzei product">
                                  </a>

                                  <div class="each-comment-title-sub-svg-div">
                                    '.$score_icon.'
                                  </div>

                                </div>

                                <div class="each-comment-content-div">
                                  <article class="each-comment-content-article">
                                    <p class="each-comment-content">
                                      '.$commentContent.'
                                    </p>
                                  </article>
                                </div>

                              </div>

                              <div class="each-comment-img-div">
                                <p class="each-comment-img-p" id="'.$CuserID.'" value="'.$imgQuantity.'" >查看圖片 ('.$imgQuantity.')</p>
                                <div class="each-comment-img-container" id="img-div-'.$CuserID.'">
                                  '.$comment_img_output.'
                                </div>

                                <div id="popup-container" class="popup-container">
                                  <span class="popup-close">
                                    <img class="img-comment-cross" src="system-svg/cross.svg" />
                                  </span>
                                  <img class="popup-img-class" id="comment-popup">
                                </div>

                              </div>';

      }/*end of loop*/

        /*add load more button*/
        $comment_output_button = '<div class="button-loadmore-div">
                                    <button class="button-loadmore" id="'.$goodsIDp.'" value="2">加載更多</button>
                                  </div>';
/*===================================================================================*/
    }
/*===================================================================================*/
    /*the the tatal amount of comments and avg rating*/
    $total_sql = "SELECT AVG(Cscore), COUNT(Cscore) FROM comment WHERE CgoodsID=?";
    $total_stmt = mysqli_stmt_init($conn);

    /*prepare*/
    if (!mysqli_stmt_prepare($total_stmt, $total_sql)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*binding*/
    } else {
      mysqli_stmt_bind_param($total_stmt, "i", $goodsIDp);
      mysqli_stmt_execute($total_stmt);
      $total_result = mysqli_stmt_get_result($total_stmt);
      $row = mysqli_fetch_array($total_result);

      $avg_score = round($row['AVG(Cscore)']);
      $total_comment = $row['COUNT(Cscore)'];

      /*get the range*/
      if ($total_comment == 0) {
        $score_output = '<span class="">-----</span>';

      }  elseif ($avg_score == 100) {
        $score_output = '<span class="score-100">'.$avg_score.'%</span>';

      } elseif ($avg_score >= 80 && $avg_score < 100) {
        $score_output = '<span class="score-80">'.$avg_score.'%</span>';

      } elseif ($avg_score >= 50 && $avg_score < 80) {
        $score_output = '<span class="score-50">'.$avg_score.'%</span>';

      } elseif ($avg_score >= 25 && $avg_score < 50) {
        $score_output = '<span class="score-25">'.$avg_score.'%</span>';

      } elseif ($avg_score >= 0 && $avg_score < 25) {
        $score_output = '<span class="score-zero">'.$avg_score.'%</span>';

      }
    }
 ?>
