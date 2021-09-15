<?php
    require 'dbh.inc.php';
    date_default_timezone_set('Asia/Hong_Kong');
    /*get the most viewed products today*/

    /*var*/
    $today = date("Y-m-d");

    /*function*/
    function countDate($dateRow) {
      /*upload date*/
      $goodsUploadDate = strtotime($dateRow);
      $date_now = strtotime(date('Y-m-d H:i:s'));

      $timeDiff = abs($date_now - $goodsUploadDate);
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

      return $numberDays;

    }

/*============================================================================================*/
    $hot_id_sql = "SELECT productID, count(productID) AS amount FROM productrecord WHERE recordDate = ? GROUP BY productID ORDER BY amount DESC LIMIT 3";
    $hot_id_stmt = mysqli_stmt_init($conn);
/*============================================================================================*/

    /*session check*/
    if (isset($_SESSION['usersEmail'])) {
      $session_check = 1;
      $sessionEmail = $_SESSION['usersEmail'];
    } else {
      $session_check = 0;
    }

/*============================================================================================*/
    /*preapre*/
    if (!mysqli_stmt_prepare($hot_id_stmt, $hot_id_sql)) {
      echo "sql error";
      exit();

      /*binding*/
    } else {
      mysqli_stmt_bind_param($hot_id_stmt, "s", $today);
      mysqli_stmt_execute($hot_id_stmt);
      $hot_id_result = mysqli_stmt_get_result($hot_id_stmt);

/*============================================================================================*/

      $hot_pd_output = '';

      while ($id_row = mysqli_fetch_array($hot_id_result)) {
        $productID_v =  $id_row['productID'];
        $total_hpd_views = $id_row['amount'];

        /*get the product's details*/
        $pd_sql = "SELECT * FROM goodsinfo WHERE goodsID=?";
        $pd_stmt = mysqli_stmt_init($conn);

        /*prepare*/
        if (!mysqli_stmt_prepare($pd_stmt, $pd_sql)) {
          echo "sql error";
          exit();

          /*binding*/
        } else {
          mysqli_stmt_bind_param($pd_stmt, "i", $productID_v);
          mysqli_stmt_execute($pd_stmt);
          $hotPD_result = mysqli_stmt_get_result($pd_stmt);
          $hotPD_details_row = mysqli_fetch_array($hotPD_result);

                  $goodsID = $hotPD_details_row['goodsID'];
                  $goodsTitle = $hotPD_details_row['goodsTitle'];
                  $goodsPrice = $hotPD_details_row['goodsPrice'];
                  $goodsUploadDate = $hotPD_details_row['goodsUploadDate'];
                  $goodsUserID = $hotPD_details_row['goodsUserID'];

                  $numberDays = countDate($hotPD_details_row['goodsUploadDate']);

          /*==========================================================================================*/

                  /*check the goods' like amount*/
                  $check_amount = "SELECT * FROM goodslike WHERE goodsID=?;";
                  $amount_stmt = mysqli_stmt_init($conn);

                  /*prepare*/
                  if (!mysqli_stmt_prepare($amount_stmt, $check_amount)) {
                    header("Location: https://www.gaakzei.com?error=sql");
                    exit();

                    /*binding*/
                  } else {
                    mysqli_stmt_bind_param($amount_stmt, "i", $goodsID);
                    mysqli_stmt_execute($amount_stmt);
                    $amount_result = mysqli_stmt_get_result($amount_stmt);
                    $like_amt = mysqli_num_rows($amount_result);

                    if (!mysqli_stmt_close($amount_stmt)) {
                      header("Location: https://www.gaakzei.com?error=sql");
                      exit();

                      /*Like system*/
                    } elseif ($session_check == 0) {

                      $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                      <div class="latest-like-img-div">
                                        <img src="https://www.gaakzei.com/like-inc/heart.svg" id="hot-'.$goodsID.'" class="heart" value="login_first">
                                      </div>
                                      <div class="latest-like-img-p-div">
                                        <p id="hot-quantity'.$goodsID.'" value="'.$like_amt.'" class="quantity" >'.$like_amt.'</p>
                                      </div>
                                  </div>';

                      } elseif ($session_check == 1) {

                        /*check if the user liked or not*/
                        $likeSQL = "SELECT * FROM goodslike WHERE goodsID=? AND userEmail=?;";
                        $likeSTMT = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($likeSTMT, $likeSQL)) {
                          header("Location: https://www.gaakzei.com?error=sql");
                          exit();

                        } else {
                          mysqli_stmt_bind_param($likeSTMT, "is", $goodsID, $sessionEmail);
                          mysqli_stmt_execute($likeSTMT);
                          $like_Result = mysqli_stmt_get_result($likeSTMT);
                          $row = mysqli_fetch_assoc($like_Result);
                          $check = mysqli_num_rows($like_Result);

                          /*stmt close*/
                          if (!mysqli_stmt_close($likeSTMT)) {
                            header("Location: https://www.gaakzei.com?error=sql");
                            exit();

                                //Echo the like img
                              } elseif ($check == 0) {
                                $img_like = '<div class="hot-like-img" value="'.$goodsID.'">
                                                <div class="latest-like-img-div">
                                                   <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="hot-'.$goodsID.'" value="'.$sessionEmail.'">
                                                </div>
                                                <div class="latest-like-img-p-div">
                                                  <p id="hot-quantity'.$goodsID.'" value="'.$like_amt.'" class="quantity" >'.$like_amt.'</p>
                                                </div>
                                                <p id="hot-change'.$goodsID.'" value="0"></p>
                                             </div>';

                              } elseif ($check == 1) {
                                $img_like = '<div class="hot-like-img" value="'.$goodsID.'">
                                                <div class="latest-like-img-div">
                                                    <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="hot-'.$goodsID.'" value="'.$sessionEmail.'">
                                                </div>
                                                <div class="latest-like-img-p-div">
                                                    <p id="hot-quantity'.$goodsID.'" value="'.$like_amt.'" class="quantity" >'.$like_amt.'</p>
                                                </div>
                                                <p id="hot-change'.$goodsID.'" value="0"></p>
                                             </div>';

                          }
                        }
                      }
                    }

                    /*===========================================================================*/
                    /*check the icon status of user*/
                    $uIconSql = "SELECT usersIcon, userShopN FROM users WHERE idusers = ?";
                    $uIconStmt = mysqli_stmt_init($conn);

                    /*prepare*/
                    if (!mysqli_stmt_prepare($uIconStmt, $uIconSql)) {
                      header("Location: https://www.gaakzei.com?error=sql");
                      exit();

                      /*binding*/
                    } else {
                      mysqli_stmt_bind_param($uIconStmt, "i", $goodsUserID);
                      mysqli_stmt_execute($uIconStmt);
                      $uIconResult = mysqli_stmt_get_result($uIconStmt);
                      $uIconRow = mysqli_fetch_array($uIconResult);

                      if ($uIconRow['usersIcon'] == 1) {
                        $uIconPath = 'user-img/'.$goodsUserID.'-profile.jpg';

                      } else {
                        $uIconPath = 'system-img/default_icon.png';
                      }
                    }

                  }
                  $hot_pd_output .=        '<li class="hot-product-li">
                                              <div class="hot-product-div">

                                                <!--***Product Top Container***-->
                                                <a class="hot-product-a" href="https://www.gaakzei.com/user-info/'.$goodsUserID.'-profile">
                                                  <div class="product-top-container">
                                                    <div class="product-top-left">
                                                      <img class="product_user_icon" src="https://www.gaakzei.com/user-info/'.$uIconPath.'" />
                                                    </div>
                                                    <div class="product-top-right">
                                                      <div class="product-user-name-div">
                                                        <p class="product-user-name-p">'.$uIconRow['userShopN'].'</p>
                                                      </div>
                                                      <div class="product-date-count-div">
                                                      <p class="product-date-count-p">'.$numberDays.'</p>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </a>
                                                <!--***END***-->

                                                <a class="hot-product-a" href="https://www.gaakzei.com/products-info/products-file/'.$goodsUserID.'-'.$goodsID.'">
                                                  <div class="product-img-cover-div">
                                                    <img class="product-img-cover" src="https://www.gaakzei.com/products-info/products-img/'.$goodsID.'-'.$goodsUserID.'-0.jpg">
                                                  </div>
                                                  <div class="product-id-container">
                                                    <p class="hot-product-a-title" >'.$goodsTitle.'</p>
                                                  </div>

                                                  <div class="price-id-container">
                                                    <div class="hot-product-a-price-div">
                                                      <p class="hot-product-a-price" >$'.$goodsPrice.'</p>
                                                    </div>
                                                    <div class="hot-product-a-id-div">
                                                      <p class="hot-product-a-id" >ID:'.$goodsID.'</p>
                                                    </div>
                                                  </div>
                                                </a>
                                                  '.$img_like.'
                                                  <p class="views-amount">點擊次數：'.$total_hpd_views.'</p>
                                              </div>
                                            </li>';
                }/*end of loop*/
              }

 ?>
