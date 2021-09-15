<?php
    /*get the latest products*/
    
    date_default_timezone_set('Asia/Hong_Kong');
/*==========================================================================================*/

    $lp_sql = "SELECT * FROM goodsinfo ORDER BY goodsID DESC LIMIT 36";
    $lp_stmt = mysqli_stmt_init($conn);

    $total_products = 0;

    /*prepare*/
    if (!mysqli_stmt_prepare($lp_stmt, $lp_sql)) {
      echo "sql error";
      exit();

      /*excution*/
    } else {
      mysqli_stmt_execute($lp_stmt);
      $lp_result = mysqli_stmt_get_result($lp_stmt);

/*==========================================================================================*/

      /*check session*/
      if (isset($_SESSION['usersEmail'])) {
        $session_check = 1;
        $sessionEmail = $_SESSION['usersEmail'];
      } else {
        $session_check = 0;
      }

/*==========================================================================================*/
      $latest_product_output = '';

      /*loop the result*/
      while ($lp_row = mysqli_fetch_array($lp_result)) {
        /*get the value*/
        $goodsID = $lp_row['goodsID'];
        $goodsTitle = $lp_row['goodsTitle'];
        $goodsPrice = $lp_row['goodsPrice'];
        $goodsUserID = $lp_row['goodsUserID'];

/*==========================================================================================*/

        /*upload date*/
        $goodsUploadDate = strtotime($lp_row['goodsUploadDate']);
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
                              <img src="https://www.gaakzei.com/like-inc/heart.svg" id="'.$goodsID.'" class="heart" value="login-first">
                            </div>
                            <div class="latest-like-img-p-div">
                              <p id="quantity'.$goodsID.'" value="'.$like_amt.'" class="quantity" >'.$like_amt.'</p>
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
                      $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                    <div class="latest-like-img-div">
                                       <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="'.$goodsID.'" value="'.$sessionEmail.'">
                                    </div>
                                    <div class="latest-like-img-p-div">
                                      <p id="quantity'.$goodsID.'" value="'.$like_amt.'" class="quantity" >'.$like_amt.'</p>
                                    </div>
                                    <p id="change'.$goodsID.'" value="0"></p>
                                   </div>';

                    } elseif ($check == 1) {
                      $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                    <div class="latest-like-img-div">
                                        <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="'.$goodsID.'" value="'.$sessionEmail.'">
                                    </div>
                                    <div class="latest-like-img-p-div">
                                        <p id="quantity'.$goodsID.'" value="'.$like_amt.'" class="quantity" >'.$like_amt.'</p>
                                    </div>
                                    <p id="change'.$goodsID.'" value="0"></p>
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

          /*===========================================================================*/

          $latest_product_output .= '<li class="latest-product-li">
                                      <div class="latest-product-div">

                                        <!--***Product Top Container***-->
                                        <a class="latest-product-a" href="https://www.gaakzei.com/user-info/'.$goodsUserID.'-profile">
                                          <div class="product-top-container">
                                            <div class="product-top-left">
                                              <img class="product_user_icon" alt="'.$uIconRow['userShopN'].'" src="https://www.gaakzei.com/user-info/'.$uIconPath.'" />
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

                                        <a class="latest-product-a" href="https://www.gaakzei.com/products-info/products-file/'.$goodsUserID.'-'.$goodsID.'">
                                          <div class="product-img-cover-div">
                                            <img class="product-img-cover" alt="'.$goodsTitle.'" src="https://www.gaakzei.com/products-info/products-img/'.$goodsID.'-'.$goodsUserID.'-0.jpg">
                                          </div>
                                          <div class="product-id-container">
                                            <p class="latest-product-a-title" >'.$goodsTitle.'</p>
                                          </div>

                                          <div class="price-id-container">
                                            <div class="latest-product-a-price-div">
                                              <p class="latest-product-a-price" >$'.$goodsPrice.'</p>
                                            </div>
                                            <div class="latest-product-a-id-div">
                                              <p class="latest-product-a-id" >ID:'.$goodsID.'</p>
                                            </div>
                                          </div>
                                        </a>
                                          '.$img_like.'
                                      </div>
                                    </li>';
                                    $total_products++;
                                    $latest_product_output .= show_ads($total_products);
        } /*End of loop*/
      }
 ?>
