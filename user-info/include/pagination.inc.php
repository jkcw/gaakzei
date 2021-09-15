<?php
  session_start();
  require '../../INCLUDES/dbh.inc.php';

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

  if (isset($_SESSION['usersEmail']) || isset($_SESSION['uid'])) {
    $session = $_SESSION['usersEmail'];
    $sessionUid = $_SESSION['uid'];
  } else {
    $sessionUid = '';
  }

  $products_per_page = 16;
  $page = '';
  $output = '';

  if (isset($_POST["page"]))
  {
      $page = $_POST["page"];
      if (isset($_POST["id"])) {
        $id = $_POST["id"];

        /*Check the owner*/
        if ($id == $sessionUid) {
          $owner_check = 1;
        } else {
          $owner_check = 0;
        }

      } else {
        echo "ID error";
      }

  }
  else {
    $page = 1;
  }

  $start_from = ($page - 1)*$products_per_page;

  $sql = "SELECT goodsID, goodsTitle, goodsPrice, goodsUploadDate
          FROM goodsinfo
          WHERE goodsUserID = ?
          ORDER BY goodsID DESC
          LIMIT $start_from, $products_per_page;";
          //Execution of query
          $stmt = mysqli_prepare($conn ,$sql);
          mysqli_stmt_bind_param($stmt, "i", $id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $total_p = mysqli_num_rows($result);

          $product_counter = 0;
          //Fetch the information
            while ($row = mysqli_fetch_array($result)) {
              $goodsID = $row['goodsID'];
              $goodsTitle = $row['goodsTitle'];
              $goodsPrice = $row['goodsPrice'];
              $goodsUploadDate = $row['goodsUploadDate'];

              $check_amount = "SELECT * FROM goodslike WHERE goodsID=?;";
              $amount_stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($amount_stmt, $check_amount)) {
                header("Location: https://www.gaakzei.com?error=sql");
                exit();
              } else {
                mysqli_stmt_bind_param($amount_stmt, "i", $goodsID);
                mysqli_stmt_execute($amount_stmt);
                $amount_result = mysqli_stmt_get_result($amount_stmt);
                $amount_num = mysqli_num_rows($amount_result);
                if (!mysqli_stmt_close($amount_stmt)) {
                  header("Location: https://www.gaakzei.com?error=sql");
                  exit();

              /*Like system*/
            } elseif (!isset($_SESSION['usersEmail'])) {
                $img_like = '<div class="profile-like-img" value="'.$goodsID.'">
                                <div class="profile-like-img-div">
                                  <img src="https://www.gaakzei.com/like-inc/heart.svg" id="'.$goodsID.'" class="heart" value="login_first">
                                </div>
                                <div class="profile-like-img-p-div">
                                  <p id="quantity'.$goodsID.'" value="'.$amount_num.'" class="quantity" >'.$amount_num.'</p>
                                </div>
                            </div>';

                //Check did the user like
              } elseif (isset($_SESSION['usersEmail'])) {

                $likeSQL = "SELECT * FROM goodslike WHERE goodsID=? AND userEmail=?;";
                $likeSTMT = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($likeSTMT, $likeSQL)) {
                  header("Location: https://www.gaakzei.com?error=sql");
                  exit();
                } else {
                  $goodsID = $row['goodsID'];
                  mysqli_stmt_bind_param($likeSTMT, "is", $goodsID, $session);
                  mysqli_stmt_execute($likeSTMT);
                  $like_Result = mysqli_stmt_get_result($likeSTMT);
                  $row = mysqli_fetch_assoc($like_Result);
                  $check = mysqli_num_rows($like_Result);
                  if (!mysqli_stmt_close($likeSTMT)) {
                    header("Location: https://www.gaakzei.com?error=sql");
                    exit();

                        //Echo the like img
                      } elseif ($check == 0) {
                        $img_like = '<div class="profile-like-img" value="'.$goodsID.'">
                                      <div class="profile-like-img-div">
                                      	 <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="'.$goodsID.'" value="'.$session.'">
                                      </div>
                                      <div class="profile-like-img-p-div">
                                        <p id="quantity'.$goodsID.'" value="'.$amount_num.'" class="quantity" >'.$amount_num.'</p>
                                      </div>
                                      <p id="change'.$goodsID.'" value="0"></p>
                                     </div>';
                      } elseif ($check == 1) {
                        $img_like = '<div class="profile-like-img" value="'.$goodsID.'">
                                      <div class="profile-like-img-div">
                                          <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="'.$goodsID.'" value="'.$session.'">
                                      </div>
                                      <div class="profile-like-img-p-div">
                                          <p id="quantity'.$goodsID.'" value="'.$amount_num.'" class="quantity" >'.$amount_num.'</p>
                                      </div>
                                      <p id="change'.$goodsID.'" value="0"></p>
                                     </div>';
                      }
                    }
                  }

                //Delete product system
              } if ($owner_check == 1) {
                /*no need*/
                $delete = '<div class="div-delete-product" >
                            <form id="delete'.$goodsID.'" class="form-delete-product" action="https://www.gaakzei.com/delete/delete-product.inc.php" method="post">
                              <input class="delete_class" height="50px" type="image" src="https://www.gaakzei.com/user-info/system-img/garbage.svg"/>
                              <input type="hidden" value="'.$goodsID.'" name="delete_goodsID"/>
                              <input type="hidden" value="'.$id.'" name="delete_ownerID"/>
                            </form>
                           </div>';
              } elseif ($owner_check == 0) {
                $delete = '';
            }
              /*End of like system*/

                $output .= '<li class="profile-product-li">
                              <div class="profile-product-div">
                                <a class="profile-product-a" href="https://www.gaakzei.com/products-info/products-file/'.$id.'-'.$goodsID.'">
                                  <div class="product-img-cover-div">
                                    <img class="product-img-cover" src="https://www.gaakzei.com/products-info/products-img/'.$goodsID.'-'.$id.'-0.jpg" alt="'.$goodsTitle.'">
                                  </div>
                                  <div>
                                    <h1 class="profile-product-a-title" >'.$goodsTitle.'</h1>
                                  </div>

                                  <div class="price-id-container">
                                    <div class="profile-product-a-price-div">
                                      <p class="profile-product-a-price" >$'.$goodsPrice.'</p>
                                    </div>
                                    <div class="profile-product-a-id-div">
                                      <p class="profile-product-a-id" >ID:'.$goodsID.'</p>
                                    </div>
                                  </div>
                                </a>
                                  '.$img_like.'
                                  '.$delete.'
                              </div>
                            </li>
                            ';
                            $product_counter++;
                            $output .= show_ads($product_counter);
           }

//Estimate the total pagese the user need
  $page_query = "SELECT * FROM goodsinfo WHERE goodsUserID = ? ORDER BY goodsID DESC;";
                $p_stmt = mysqli_prepare($conn ,$page_query);
                mysqli_stmt_bind_param($p_stmt, "i", $id);
                mysqli_stmt_execute($p_stmt);
                $page_result = mysqli_stmt_get_result($p_stmt);
                $total_products = mysqli_num_rows($page_result);
                //echo $total_products;
                $total_pages = ceil($total_products/$products_per_page);
                mysqli_stmt_close($p_stmt);
                //echo $total_pages;

          $prev = $page - 1 ;
          $next = $page + 1 ;

          if ($page == 1) {

            if ($total_products <= $products_per_page) {
              $output .= "";
            } else {
              $output .= '<div class="profile-ajax-button">
                           <button class="next" type="button" name="button" style="cursor:pointer" id="'.$next.'">下一頁</button>
                          </div>';
              }

          } elseif ($page == $total_pages) {

            if ($total_products <= $products_per_page) {
              $output .= "";

            } else {
              $output .= '<div class="profile-ajax-button">
                            <button class="prev" type="button" name="button" style="cursor:pointer" id="'.$prev.'">上一頁</button>
                          </div>';
            }
          } else {

            $output .= '<div class="profile-ajax-button">
                          <button class="prev" type="button" name="button" style="cursor:pointer" id="'.$prev.'">上一頁</button>
                          <button class="next" type="button" name="button" style="cursor:pointer" id="'.$next.'">下一頁</button>
                        </div>';

          }


                      echo $output;
