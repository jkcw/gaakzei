<?php
    session_start();
    require '../../INCLUDES/dbh.inc.php';
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

    $output = '';

    if (!isset($_POST['page']) || !isset($_POST['email'])) {
      header("Location: https://www.gaakzei.com/INCLUDES/login");
      exit();
    } else {
      $page = $_POST['page'];
      $email = $_POST['email'];
      $uid = $_POST['uid'];
      
      $product_count = 0;

      $products_per_page = 20;

      $start_from = ($page - 1)*$products_per_page;

      $sql_goodslike = "SELECT goodsID FROM goodslike WHERE userEmail = ? AND deleted = 0 ORDER BY primaryKey DESC LIMIT $start_from, $products_per_page ;";
      $stmt_goodslike = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt_goodslike, $sql_goodslike)) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();
      } else {

        mysqli_stmt_bind_param($stmt_goodslike, "s", $email);
        mysqli_stmt_execute($stmt_goodslike);
        $result = mysqli_stmt_get_result($stmt_goodslike);
        /*Finished fetching the database goodslike*/

        /*Start mian loop*/

        $uid = $_POST['uid'];
        $email = $_POST['email'];

        while ($row = mysqli_fetch_array($result)) {
          $goodsID = $row['goodsID'];

          /*Start fetching liked products*/
          $goods_sql = "SELECT goodsID, goodsUserID, goodsTitle, goodsPrice, goodsUploadDate
                        FROM goodsinfo
                        WHERE goodsID=?
                        ;";
          $goods_stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($goods_stmt, $goods_sql)) {
            header("Location: https://www.gaakzei.com?error=sql");
            exit();

          } else {
            mysqli_stmt_bind_param($goods_stmt, "i", $goodsID);
            mysqli_stmt_execute($goods_stmt);
            $result_goods = mysqli_stmt_get_result($goods_stmt);
            $goods_row = mysqli_fetch_array($result_goods);

            $goodsTitle = $goods_row['goodsTitle'];
            $goodsPrice = $goods_row['goodsPrice'];
            $goodsUserID = $goods_row['goodsUserID'];

            $numberDays = countDate($goods_row['goodsUploadDate']);
            /*Data of the selected product*/
            mysqli_stmt_close($goods_stmt);
/*=================================================================================*/

            /*imgs_like*/

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
                // code...
              }
            }

/*========================================================================================*/

            /*check the icon status of user*/
            $uIconSql = "SELECT usersIcon, userShopN FROM users WHERE idusers = ?";
            $uIconStmt = mysqli_stmt_init($conn);

            /*prepare*/
            if (!mysqli_stmt_prepare($uIconStmt, $uIconSql)) {
              header("Location: //locaohost/GaakZei?error=sql");
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

            mysqli_stmt_close($uIconStmt);

/*========================================================================================*/

            $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                          <div class="latest-like-img-div">
                              <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="'.$goodsID.'" value="'.$email.'">
                          </div>
                          <div class="latest-like-img-p-div">
                              <p id="quantity'.$goodsID.'" value="'.$amount_num.'" class="quantity" >'.$amount_num.'</p>
                          </div>
                            <p id="change'.$goodsID.'" value="0"></p>
                         </div>';

            /*=================================================================================*/

            /*Output of product*/
            $output .=                '<li class="latest-product-li">
                                        <div class="latest-product-div">

                                          <!--***Product Top Container***-->
                                          <a class="latest-product-a" href="../../user-info/'.$goodsUserID.'-profile">
                                            <div class="product-top-container">
                                              <div class="product-top-left">
                                                <img class="product_user_icon" src="../../user-info/'.$uIconPath.'" />
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

                                          <a class="latest-product-a" href="../../products-info/products-file/'.$goodsUserID.'-'.$goodsID.'">
                                            <div class="product-img-cover-div">
                                              <img class="product-img-cover" src="../../products-info/products-img/'.$goodsID.'-'.$goodsUserID.'-0.jpg">
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
                                      </li>
                    ';
                    $product_count++;
                    $output .= show_ads($product_count);
          }
        }

        $page_query = "SELECT * FROM goodslike WHERE userID = ? ORDER BY goodsID DESC;";
                      $p_stmt = mysqli_prepare($conn ,$page_query);
                      mysqli_stmt_bind_param($p_stmt, "i", $uid);
                      mysqli_stmt_execute($p_stmt);
                      $page_result = mysqli_stmt_get_result($p_stmt);
                      $total_products = mysqli_num_rows($page_result);
                      //echo $total_products;
                      $total_pages = ceil($total_products/$products_per_page);
                      mysqli_stmt_close($p_stmt);

                      /*End of calculate the number of page*/
                      $prev = $page - 1 ;
                      $next = $page + 1 ;

                      if ($page == 1) {

                        if ($total_products <= $products_per_page) {
                          $output .= "";
                        } else {
                          $output .= "<button class='next' type='button' name='button' style='cursor:pointer' id='".$next."'>下一頁</button>";
                          }

                      } elseif ($page == $total_pages) {

                        if ($total_products <= $products_per_page) {
                          $output .= "";

                        } else {
                          $output .= "<button class='prev' type='button' name='button' style='cursor:pointer' id='".$prev."'>上一頁</button>";
                        }

                      } else {

                        $output .= "<button class='prev' type='button' name='button' style='cursor:pointer' id='".$prev."'>上一頁</button>
                                    <button class='next' type='button' name='button' style='cursor:pointer' id='".$next."'>下一頁</button>";

                      }


                                  echo $output;
                                  mysqli_stmt_close($stmt_goodslike);

      }
    }
