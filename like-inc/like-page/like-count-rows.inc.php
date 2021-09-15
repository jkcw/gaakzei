<?php
  require '../../INCLUDES/dbh.inc.php';

  $products_per_page = 20;
  if (isset($_POST["uid"])) {
    $id = $_POST["uid"];
  } else {
    echo "ID error";
  }

  $page_query = "SELECT * FROM goodslike WHERE userID = ? ORDER BY goodsID DESC;";
                $p_stmt = mysqli_prepare($conn ,$page_query);
                mysqli_stmt_bind_param($p_stmt, "i", $id);
                mysqli_stmt_execute($p_stmt);
                $page_result = mysqli_stmt_get_result($p_stmt);
                $total_products = mysqli_num_rows($page_result);

                $total_pages = ceil($total_products/$products_per_page);



                      echo $total_pages;
