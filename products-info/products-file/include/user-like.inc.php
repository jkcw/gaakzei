<?php
    /*Get the total like amount of the product*/
    $quantitySQL = "SELECT * FROM goodslike WHERE goodsID=?;";
    $quantitySTMT = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($quantitySTMT, $quantitySQL)) {
      header("Location: https://www.gaakzei.com?error");
      exit();
    } else {
      mysqli_stmt_bind_param($quantitySTMT, "i", $goodsIDp);
      mysqli_stmt_execute($quantitySTMT);
      $quantity_result = mysqli_stmt_get_result($quantitySTMT);
      $amount = mysqli_num_rows($quantity_result);
    }

    if (!isset($_SESSION['usersEmail'])) {
      $like_output = '<div class="heart-div">
                        <img class="heart" src="https://www.gaakzei.com/like-inc/heart.svg" id="login_first" height="50px">
                      </div>
                      <div class="like-number-div">
                        <p id="quantity'.$goodsIDp.'" value="'.$amount.'" class="quantity" >'.$amount.'</p>
                      </div>';
    } else {

    $sessionEmail = $_SESSION['usersEmail'];

    $likeSQL = "SELECT * FROM goodslike WHERE goodsID=? AND userEmail=?;";
    $likeSTMT = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($likeSTMT, $likeSQL)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();
    } else {
      mysqli_stmt_bind_param($likeSTMT, "is", $goodsIDp, $sessionEmail);
      mysqli_stmt_execute($likeSTMT);
      $like_Result = mysqli_stmt_get_result($likeSTMT);
      $row = mysqli_fetch_assoc($like_Result);
      $check = mysqli_num_rows($like_Result);
      if (!mysqli_stmt_close($likeSTMT)) {
        header("Location: https://www.gaakzei.com?error=sql");
        exit();
      } else {


      }
      if ($check == 0) {
        $like_output = '<div class="heart-div">
                          <img src="https://www.gaakzei.com/like-inc/heart.svg" class="heart" id="'.$goodsIDp.'" value="'.$sessionEmail.'">
                        </div>
                        <div class="like-number-div">
                          <p id="quantity'.$goodsIDp.'" value="'.$amount.'" class="quantity" >'.$amount.'</p>
                        </div>';
      } elseif ($check == 1) {
        $like_output = '<div class="heart-div">
                          <img src="https://www.gaakzei.com/like-inc/heart-pink.svg" class="heart" id="'.$goodsIDp.'" value="'.$sessionEmail.'">
                        </div>
                        <div class="like-number-div">
                          <p id="quantity'.$goodsIDp.'" value="'.$amount.'" class="quantity" >'.$amount.'</p>
                        </div>';
      }
    }
  }
