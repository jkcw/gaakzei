<?php

  date_default_timezone_set('Asia/Hong_Kong');

  require 'include/inc-function.inc.php';
/*=======================================================================================*/

    /*Check get*/
    if (!isset($_GET['ct']) || !isset($_GET['query']) || !isset($_GET['page'])) {
      echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
      //exit();

/*---------------------------------------------------------------------------------------------------------------*/

      /*Validate the value*/
    } elseif (isset($_GET['error'])) {
      if ($_GET['error'] == 'noresult') {
        echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
      }
    } else {

      /*Sql order by method*/
      $default = 'goodsID';
      $category = $_GET['ct'];
      $search = varify_query($_GET['query']);
      $page = $_GET['page'];
      
      /* sift */
      $district_sift = query_index_district();
      $color_sift = query_index_color();


      $products_per_page = 16;
      $start_from = ($page - 1)*$products_per_page;
      $error_message = '';
      $output = "";
      /*Validate category*/
      if ($category == null) {
        echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
        //exit();

/*---------------------------------------------------------------------------------------------------------------*/

        /*If the user search for products*/
        /*Part A*/
      } elseif ($category == 'Products') {
        $new_ct = 'Products';
        $search_exploded = explode( " ", $search);

        /*Loop and making sql*/
        $count = 0;
        $pattern = "/'=/i";
        $title = "";
        $construct = "";
        $query_path = '';

        foreach ($search_exploded as $key) {
          $count++;

          /*Check illegal pattern*/
          if (preg_match($pattern, $key)) {
            echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
            //exit();

            /*Passed*/
          } else {

          if ($count == 1) {
            $construct .= "CONCAT_WS(keyword1,keyword2,keyword3,goodsIDky,userID) LIKE '%$key%' ";
            $title .= "OR goodsTitle LIKE '%$key%' ";
          } else {
            $construct .= "OR CONCAT_WS(keyword1,keyword2,keyword3,goodsIDky,userID) LIKE '%$key%' ";
            $title .= "OR goodsTitle LIKE '%$key%' ";
          }
        }
      }

        /*Start searching GoodsID*/
        $sql_1 = "SELECT goodsIDky FROM keywords WHERE $construct";
        $stmt_1 = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_1, $sql_1)) {
          echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
          //exit();
        } else {
          mysqli_stmt_execute($stmt_1);
          $result_1 = mysqli_stmt_get_result($stmt_1);

/*------------------------------------------------------------------------------------*/

          /*loop the id*/
          $count_id = 0;
          $id_row = "";

          

          while ($id_1 = mysqli_fetch_array($result_1)) {
            $goodsID_1 = $id_1['goodsIDky'];
            $count_id++;

            if ($count_id == 1) {
              $id_row .= "'".$goodsID_1."'";
            } else {
              $id_row .= ",'".$goodsID_1."'";
            }
          } /*End of loop*/
          $district_output = district_count($conn, $id_row, $search, $color_sift);
          $color_output = color_count($conn, $id_row, $search, $district_sift);
          $district_cancel_output = district_count_cancel_button($search, $color_sift);
          $color_cancel_output = color_count_cancel_button($search, $district_sift);
          $sort_output = sort_sql($search, $district_sift, $color_sift);
          $order_by = get_sort($default);

          /*Start final sql*/
          $final_sql_a = sql_sift($district_sift, $color_sift, $id_row, $order_by, $start_from, $products_per_page);

          $final_stmt_a = mysqli_stmt_init($conn);

          /*Prepare*/
          if (!mysqli_stmt_prepare($final_stmt_a, $final_sql_a)) {
            echo '<h3 class="system_message" style="text-align: center; margin-top: 80px;">唔好意思，沒有搜尋結果。請試一下其他關鍵字。</h3>';
            $pagination = '';
            $output = '';
            //exit();
            /*Execution*/
          } else {
            mysqli_stmt_execute($final_stmt_a);
            $final_result_a = mysqli_stmt_get_result($final_stmt_a);

/*------------------------------------------------------------------------------------*/
            $totalProducts = 0;            

            /*Final Loop*/
            while ($final_row_a = mysqli_fetch_array($final_result_a)) {
              $ownerID = $final_row_a['goodsUserID'];
              $goodsID = $final_row_a['goodsID'];
              $goodsTitle = $final_row_a['goodsTitle'];
              $goodsPrice = $final_row_a['goodsPrice'];

              $totalProducts++;

              $numberDays = countDate($final_row_a['goodsUploadDate']);
/*------------------------------------------------------------------------------------*/
              //Get the like amount
              $like_amount_func_sql = "SELECT * FROM goodslike WHERE goodsID=?";
              $like_amount_func_stmt = mysqli_stmt_init($conn);

              /*Prepare*/
              if (!mysqli_stmt_prepare($like_amount_func_stmt, $like_amount_func_sql)) {
                echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
                //exit();

                /*Binding*/
              } else {
                mysqli_stmt_bind_param($like_amount_func_stmt, "i", $goodsID);
                mysqli_stmt_execute($like_amount_func_stmt);
                $like_amount_func_result = mysqli_stmt_get_result($like_amount_func_stmt);
                $num_of_like = mysqli_num_rows($like_amount_func_result);
              }

/*------------------------------------------------------------------------------------*/

              /*Like system*/
              if (!isset($_SESSION['uid'])) {
                $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                              <div class="latest-like-img-div">
                                <img src="https://www.gaakzei.com/like-inc/heart.svg" id="'.$goodsID.'" class="heart" value="login_first">
                              </div>
                              <div class="latest-like-img-p-div">
                                <p id="quantity'.$goodsID.'" value="'.$num_of_like.'" class="quantity" >'.$num_of_like.'</p>
                              </div>
                             </div>';

                //Check did the user like

              } elseif (isset($_SESSION['uid'])) {

                $ownerID_session = $_SESSION['uid'];
                $session = $_SESSION['usersEmail'];

                $likeSQL = "SELECT * FROM goodslike WHERE goodsID=? AND userID=?;";
                $likeSTMT = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($likeSTMT, $likeSQL)) {
                  echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
                  //exit();
                } else {
                  $goodsID = $final_row_a['goodsID'];
                  mysqli_stmt_bind_param($likeSTMT, "is", $goodsID, $ownerID_session);
                  mysqli_stmt_execute($likeSTMT);
                  $like_Result = mysqli_stmt_get_result($likeSTMT);
                  $row = mysqli_fetch_assoc($like_Result);
                  $check = mysqli_num_rows($like_Result);

                  /*Close*/
                  if (!mysqli_stmt_close($likeSTMT)) {
                    echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
                    //exit();

/*----------------------------------*/
                        //Echo the like img
                      } elseif ($check == 0) {
                        $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                      <div class="latest-like-img-div">
                                         <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="'.$goodsID.'" value="'.$session.'">
                                      </div>
                                      <div class="latest-like-img-p-div">
                                        <p id="quantity'.$goodsID.'" value="'.$num_of_like.'" class="quantity" >'.$num_of_like.'</p>
                                      </div>
                                      <p id="change'.$goodsID.'" value="0"></p>
                                     </div>';

                      } elseif ($check == 1) {
                        $img_like = '<div class="latest-like-img" value="'.$goodsID.'">
                                      <div class="latest-like-img-div">
                                          <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="'.$goodsID.'" value="'.$session.'">
                                      </div>
                                      <div class="latest-like-img-p-div">
                                          <p id="quantity'.$goodsID.'" value="'.$num_of_like.'" class="quantity" >'.$num_of_like.'</p>
                                      </div>
                                      <p id="change'.$goodsID.'" value="0"></p>
                                     </div>';

                      }
                    }
                  }

                  /*===========================================================================*/
                    /*check the icon status of user*/
                    $uIconSql = "SELECT usersIcon, userShopN FROM users WHERE idusers = ?";
                    $uIconStmt = mysqli_stmt_init($conn);

                    /*prepare*/
                    if (!mysqli_stmt_prepare($uIconStmt, $uIconSql)) {
                      echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
                      //exit();

                      /*binding*/
                    } else {
                      mysqli_stmt_bind_param($uIconStmt, "i", $ownerID);
                      mysqli_stmt_execute($uIconStmt);
                      $uIconResult = mysqli_stmt_get_result($uIconStmt);
                      $uIconRow = mysqli_fetch_array($uIconResult);

                      

                      if ($uIconRow['usersIcon'] == 1) {
                        $uIconPath = 'user-img/'.$ownerID.'-profile.jpg';

                      } else {
                        $uIconPath = 'system-img/default_icon.png';
                      }
                    }

                    /*===========================================================================*/
/*------------------------------------------------------------------------------------*/

              $output .=               '<li class="latest-product-li">
                                          <div class="latest-product-div">

                                            <!--***Product Top Container***-->
                                            <a class="latest-product-a" href="https://www.gaakzei.com/user-info/'.$ownerID.'-profile.php">
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

                                            <a class="latest-product-a" href="https://www.gaakzei.com/products-info/products-file/'.$ownerID.'-'.$goodsID.'.php">
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
                          $output .= play_ads($totalProducts);
            } /*End of loop*/
            require 'total-result.inc.php';
            $total_pages = ceil($number_of_result/$products_per_page);
            require 'pagination.inc.php';
          }
        }

        $sift_output = '    <!--Remember to delete comments after fininshed your work-->
                            <!--Main Container of sift-->
                            
                            <div class="filter-main-container">
                        
                              <div class="filter-title-container">
                                <p class="filter-title">所有分類</p>
                              </div>
                        
                              <div class="filter-container">
                                <div class="filter-item">
                                  '.$district_output.'
                                </div>
                        
                                <div class="filter-item">
                                  '.$color_output.'
                                </div>
                        
                                <div class="filter-item">
                                  '.$sort_output.'
                                </div>
                              <!--edit the inc-function.inc.php inside include directory-->
                              </div>
                            </div>';

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/




      /*If search user*/
      } elseif ($category == 'Users') {
        $sift_output = '';
        $new_ct = 'Users';
        $search_exploded = explode( " ", $search);

        /*Loop and making sql*/
        $count = 0;
        $totalProducts = 0;
        $pattern = "/'=/i";
        $title = "";
        $construct = "";

        foreach ($search_exploded as $key) {
          $count++;

          /*Check illegal pattern*/
          if (preg_match($pattern, $key)) {
            echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
            //exit();

            /*Passed*/
          } else {

          if ($count == 1) {
            $construct .= "CONCAT_WS(idusers, uidUsers, userContactEmail, userShopN, userPhoneN) LIKE '%$key%' ";
          } else {
            $construct .= "OR CONCAT_WS(idusers, uidUsers, userContactEmail, userShopN, userPhoneN) LIKE '%$key%' ";
          }
        }
      }
        $products_per_page = 10;
        $start_from = ($page - 1)*$products_per_page;

        /*Start searching UserID*/
        $sql_user = "SELECT idusers, userShopN, userPhoneN, userDate FROM users WHERE $construct AND verified = 1 ";
        $stmt_user = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_user, $sql_user)) {
          echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
          //exit();
        } else {
          mysqli_stmt_execute($stmt_user);
          $result_user = mysqli_stmt_get_result($stmt_user);

          /*Loop the user information*/
          while ($user_row = mysqli_fetch_array($result_user)) {
            $idusers = $user_row['idusers'];
            $userShopN = $user_row['userShopN'];
            $userPhoneN = $user_row['userPhoneN'];
            $userDate = $user_row['userDate'];

            $userJoinDate = explode(' ', $userDate);

            $sql_followers = "SELECT * FROM follow WHERE ownerID=?";
            $stmt_followers = mysqli_stmt_init($conn);

            /*Prepare*/
            if (!mysqli_stmt_prepare($stmt_followers, $sql_followers)) {
              echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
              //exit();

              /*Binding*/
            } else {
              mysqli_stmt_bind_param($stmt_followers, "i", $idusers);
              mysqli_stmt_execute($stmt_followers);
              $result_followers = mysqli_stmt_get_result($stmt_followers);
              $number_of_followers = mysqli_num_rows($result_followers);
            }

            /*===========================================================================*/
            /*check the icon status of user*/
            $uIconSql = "SELECT usersIcon, userShopN FROM users WHERE idusers = ?";
            $uIconStmt = mysqli_stmt_init($conn);

            /*prepare*/
            if (!mysqli_stmt_prepare($uIconStmt, $uIconSql)) {
              echo '<h3 style="text-align:center;">唔好意思，沒有符合結果</h3>';
              //exit();

              /*binding*/
            } else {
              mysqli_stmt_bind_param($uIconStmt, "i", $idusers);
              mysqli_stmt_execute($uIconStmt);
              $uIconResult = mysqli_stmt_get_result($uIconStmt);
              $uIconRow = mysqli_fetch_array($uIconResult);

              $path_profile = $idusers.'-profile.php';

              if ($uIconRow['usersIcon'] == 1) {
                $uIconPath = 'user-img/'.$idusers.'-profile.jpg';

              } else {
                $uIconPath = 'system-img/default_icon.png';
              }
            }

            $avg_rating_span = avgRating($idusers, $conn);

            /*===========================================================================*/

            //Check shop name
            if ($userShopN == null) {
              $userShopN = "此用戶暫時沒有Store Name";
            } 

            //check phone
            if ($userPhoneN == 0) {
              $userPhoneN = '---- ----';
            }

            $output .= '
                        <a class="user-box-a" href="https://www.gaakzei.com/user-info/'.$path_profile.'">

                            <div class="user-box-container">

                              <div class="user-left-container">
                                <img class="user-search-icon" src="https://www.gaakzei.com/user-info/'.$uIconPath.'">
                              </div>

                              <div class="user-right-container">

                                  <div class="flex1">
                                    <h2 class="user-store-name">'.$userShopN.' 
                                      <span class="user-id-span">ID：'.$idusers.'</sapn> 
                                      '.$avg_rating_span.'
                                    </h2>
                                  </div>

                                  <div class="flex2">
                                    <p class="user-other-info-p">電話：'.$userPhoneN.'</p>
                                  </div>

                                  <div class="flex3">
                                    <p class="user-other-info-p">加入日期：'.$userJoinDate[0].'</p>
                                  </div>

                                  <div class="flex4">
                                    <p class="user-other-info-p">Followers：'.$number_of_followers.'</p>
                                  </div>

                              </div>

                            </div>
                          </a>
                        ';

                        $totalProducts++;

          } /*End of while loop*/
/*------------------------------------------------------------------------------------*/

            } /*End of loop*/
            $total_pages = ceil($number_of_result/$products_per_page);
            require 'pagination.inc.php';
          }
        }
