<?php
    date_default_timezone_set('Asia/Hong_Kong');

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

    function show_ads($i) {
      $num = $i%8;
      if ($num == 0) {
        return '<div class="mid-ad" style="text-align:center;">
                      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                      <ins class="adsbygoogle"
                          style="display:inline-block;width:728px;height:90px"
                          data-ad-client="ca-pub-8589551961577205"
                          data-ad-slot="3048224575"></ins>
                      <script>
                          (adsbygoogle = window.adsbygoogle || []).push({});
                      </script>
                    </div>';
      }
    }
/*=======================================================================================*/
    if (!isset($_SESSION['uid'])) {
      header("Location: https://www.gaakzei.com/INCLUDES/login?error=nologin");
      exit();

/*--------------------------------------------------------------------------------------------------------------*/

      /*SQL*/
    } else {
      $uid = $_SESSION['uid'];
      $email = $_SESSION['usersEmail'];
      $sql = "SELECT ownerID FROM follow WHERE followerID=?;";
      $stmt = mysqli_stmt_init($conn);

      $product_count = 0;

      /*Prepare*/
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com/INCLUDES/login?error=nologin");
        exit();

        /* Binding */
      } else {
        mysqli_stmt_bind_param($stmt, "i", $uid);
        mysqli_stmt_execute($stmt);
        $result_row = mysqli_stmt_get_result($stmt);

        $count = 0;

        while ($result_array = mysqli_fetch_array($result_row)) {

          $oID[] = $result_array['ownerID'];
          $count++;

        }

        /*Close STMT*/
        if (!mysqli_stmt_close($stmt)) {
          header("Location: https://www.gaakzei.com/INCLUDES/login?error=nologin");
          exit();

          /*Check num*/
        } elseif ($count == 0) {
          echo "<h4>唔好意思，似乎你未有追蹤任何用戶</h4>";

/*--------------------------------------------------------------------------------------------------------------*/

          /*If yes*/
      } elseif ($count > 0) {

        $comma_separated = implode(",", $oID);

        $data_sql = "SELECT * FROM goodsinfo WHERE goodsUserID IN ($comma_separated) ORDER BY goodsID DESC LIMIT 30";
        $data_stmt = mysqli_stmt_init($conn);

        /*Prepare*/
        if (!mysqli_stmt_prepare($data_stmt, $data_sql)) {
          header("Location: https://www.gaakzei.com/INCLUDES/login?error=nologin");
          exit();

          /*Binding*/
        } else {
          mysqli_stmt_execute($data_stmt);
          $data_result = mysqli_stmt_get_result($data_stmt);

          /*Loop the data*/
          while ($data = mysqli_fetch_array($data_result)) {

            $goodsID = $data['goodsID'];
            $ownerID = $data['goodsUserID'];
            $goodsTitle = $data['goodsTitle'];
            $goodsPrice = $data['goodsPrice'];

            $numberDays = countDate($data['goodsUploadDate']);

            if (!isset($_SESSION['usersEmail'])) {
              $img_like = '<img src="https://www.gaakzei.com/like-inc/heart.svg" height="50px" class="login_first" >';

              //Check did the user like
            } elseif (isset($_SESSION['usersEmail'])) {

              $like_count_sql = "SELECT * FROM goodslike WHERE goodsID=?;";
              $like_count_stmt = mysqli_stmt_init($conn);

              /*prepare*/
              if (!mysqli_stmt_prepare($like_count_stmt, $like_count_sql)) {
                header("Location: https://www.gaakzei.com?error=sql");
                exit();

                /*binding*/
              } else {
                mysqli_stmt_bind_param($like_count_stmt, "i", $goodsID);
                mysqli_stmt_execute($like_count_stmt);
                $amount_result = mysqli_stmt_get_result($like_count_stmt);
                $amount_num = mysqli_num_rows($amount_result);

                /*close*/
                if (!mysqli_stmt_close($like_count_stmt)) {
                  header("Location: https://www.gaakzei.com?error=sql");
                  exit();

                  /*check like status*/
                } else {
                  $like_check_sql = "SELECT * FROM goodslike WHERE goodsID=? AND userEmail=?;";
                  $like_check_stmt = mysqli_stmt_init($conn);

                  /*prepare*/
                  if (!mysqli_stmt_prepare($like_check_stmt, $like_check_sql)) {
                    header("Location: https://www.gaakzei.com?error=sql");
                    exit();

                    /*binding*/
                  } else {
                    mysqli_stmt_bind_param($like_check_stmt, "is", $goodsID, $email);
                    mysqli_stmt_execute($like_check_stmt);
                    $like_Result = mysqli_stmt_get_result($like_check_stmt);
                    $check = mysqli_num_rows($like_Result);

                    /*close*/
                    if (!mysqli_stmt_close($like_check_stmt)) {
                      header("Location: https://www.gaakzei.com?error=sql");
                      exit();

                    } elseif ($check == 0) {
                      $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                    <div class="latest-like-img-div">
                                       <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="'.$goodsID.'" value="'.$email.'">
                                    </div>
                                    <div class="latest-like-img-p-div">
                                      <p id="quantity'.$goodsID.'" value="'.$amount_num.'" class="quantity" >'.$amount_num.'</p>
                                    </div>
                                    <p id="change'.$goodsID.'" value="0"></p>
                                   </div>';

                    } elseif ($check == 1) {
                      $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                    <div class="latest-like-img-div">
                                        <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="'.$goodsID.'" value="'.$email.'">
                                    </div>
                                    <div class="latest-like-img-p-div">
                                        <p id="quantity'.$goodsID.'" value="'.$amount_num.'" class="quantity" >'.$amount_num.'</p>
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
                mysqli_stmt_bind_param($uIconStmt, "i", $ownerID);
                mysqli_stmt_execute($uIconStmt);
                $uIconResult = mysqli_stmt_get_result($uIconStmt);
                $uIconRow = mysqli_fetch_array($uIconResult);

                if ($uIconRow['usersIcon'] == 1) {
                  $uIconPath = 'user-info/user-img/'.$ownerID.'-profile.jpg';

                } else {
                  $uIconPath = 'user-info/system-img/default_icon.png';
                }
              }

            }
            /*End of like system*/

              $output .= '<li class="latest-product-li">
                                          <div class="latest-product-div">

                                            <!--***Product Top Container***-->
                                            <a class="latest-product-a" href="https://www.gaakzei.com/user-info/'.$ownerID.'-profile">
                                              <div class="product-top-container">
                                                <div class="product-top-left">
                                                  <img class="product_user_icon" src="https://www.gaakzei.com/'.$uIconPath.'" />
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

                                            <a class="latest-product-a" href="https://www.gaakzei.com/products-info/products-file/'.$ownerID.'-'.$goodsID.'">
                                              <div class="product-img-cover-div">
                                                <img class="product-img-cover" src="https://www.gaakzei.com/products-info/products-img/'.$goodsID.'-'.$ownerID.'-0.jpg">
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
                                        $product_count++;
                                        $output .= show_ads($product_count);
                    }
                  }
                }
              }
            }
