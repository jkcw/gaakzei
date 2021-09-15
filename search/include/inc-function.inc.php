<?php
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

  function avgRating($avgRating_uid, $conn) {

    $avgR_sql = "SELECT AVG(Cscore), COUNT(Cscore) FROM comment WHERE ownerID = ?;";
    $avgR_stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($avgR_stmt, $avgR_sql)) {
      header("Location: https://www.gaakzei.com?error=sql");

  /* Binding */
    } else {

        mysqli_stmt_bind_param($avgR_stmt, "i", $avgRating_uid);
        mysqli_stmt_execute($avgR_stmt);
        $avgRating_result = mysqli_stmt_get_result($avgR_stmt);
        $avgRating_row = mysqli_fetch_array($avgRating_result);
        
        $totalComment = $avgRating_row['COUNT(Cscore)'];

        /* if there is no comment */
        if ($totalComment == 0) {
            $roundedAvgRating = '<span class="no-rating">---</span>';

        } else {
            $avgRating = $avgRating_row['AVG(Cscore)'];

            if ($avgRating == 100) {
              $rating_color = 'rgb(2, 148, 73)';
  
            } elseif ($avgRating >= 80 && $avgRating < 100) {
              $rating_color = 'rgb(145, 198, 68)';
  
            } elseif ($avgRating >= 50 && $avgRating < 80) {
              $rating_color = 'rgb(178, 168, 147)';
  
            } elseif ($avgRating >= 25 && $avgRating < 50) {
              $rating_color = 'rgb(248, 148, 28)';
  
            } elseif ($avgRating >= 0 && $avgRating < 25) {
              $rating_color = 'rgb(247, 26, 38)';
            }

            $roundedAvgRating = '<span class="rated-span" style="color:'.$rating_color.'">('.round($avgRating).')</span>';
        }

        return $roundedAvgRating;
  }
}


function varify_query($query) {

  if ($query == null) {
    return '';
  } else {
    $arr = str_split($query);

    foreach ($arr as &$value) {
  
      $equal = '=';
      if ($value == $equal || $value == '?' || $value == '\'') {
        $value = '';
      } else {
  
      }
    }
    return implode("",$arr);
  }
}


function district_count($conn, $id_row, $query, $color) {
  $output = '';

  $sql = "SELECT goodsDistrict, COUNT(*)
          FROM goodsinfo
          WHERE goodsID IN ($id_row)
          GROUP BY goodsDistrict
          ORDER BY COUNT(*) DESC
          LIMIT 9
          ";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo '<h3 class="system_message" style="text-align: center; margin-top: 80px;">唔好意思，沒有搜尋結果。請試一下其他關鍵字。</h3>';
        $pagination = '';
        $output = '';
        require '../INCLUDES/footer.php';
        exit();

  } else {
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);

      while ($row = mysqli_fetch_array($result)) {
        $district = $row['goodsDistrict'];
        $total = $row['COUNT(*)'];
        $output .= '<a class="district-r" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'&color='.$color.'">'.$district.'('.$total.')'.'</a>';
      }
  }

  return $output;

}

function color_count($conn, $id_row, $query, $district) {
  $output = '';

  $sql = "SELECT goodsColor, COUNT(*)
          FROM goodsinfo
          WHERE goodsID IN ($id_row)
          GROUP BY goodsColor
          ORDER BY COUNT(*) DESC
          LIMIT 9
          ";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo '<h3 class="system_message" style="text-align: center; margin-top: 80px;">唔好意思，沒有搜尋結果。請試一下其他關鍵字。</h3>';
          $pagination = '';
          $output = '';
          require '../INCLUDES/footer.php';
          exit();

  } else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_array($result)) {
      $color = $row['goodsColor'];
      $total = $row['COUNT(*)'];
      $output .= '<a class="color-r" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'&color='.$color.'">'.$color.'('.$total.')'.'</a>';
    }
}

return $output;
}

function color_count_cancel_button ($query, $district) {
  return '<a class="color-r" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'">重設</a>';
}

function district_count_cancel_button ($query, $color) {
  return '<a class="district-r" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1">重設</a>';
}

function query_index_district() {

  if (isset($_GET['district'])) {
    $district_sift = $_GET['district'];
   } else {
    $district_sift = null;
   }

  return $district_sift;
}

function query_index_color() {
  
  if (isset($_GET['color'])) {
    $color_sift = $_GET['color'];
  } else {
     $color_sift = null;
  }

  return $color_sift;
}

function sql_sift($district, $color, $id_row, $order_by, $start_from, $products_per_page) {

  $district = varify_query($district);
  $color = varify_query($color);

  if ($district != null || $color != null) {

    if ($district != null && $color != null) {
      $sql = 'SELECT * FROM goodsinfo WHERE goodsID IN ('.$id_row.') AND goodsDistrict = "'.$district.'" AND goodsColor = "'.$color.'" '.$order_by.' LIMIT '.$start_from.', '.$products_per_page.'';

    } else {
      if ($district != null) {
        $sql = 'SELECT * FROM goodsinfo WHERE goodsID IN ('.$id_row.') AND goodsDistrict = "'.$district.'" '.$order_by.' LIMIT '.$start_from.', '.$products_per_page.'';

      } elseif ($color != null) {
        $sql = 'SELECT * FROM goodsinfo WHERE goodsID IN ('.$id_row.') AND goodsColor = "'.$color.'" '.$order_by.' LIMIT '.$start_from.', '.$products_per_page.'';

      }
    }

  } else {
    $sql = 'SELECT * FROM goodsinfo WHERE goodsID IN ('.$id_row.') '.$order_by.' LIMIT '.$start_from.', '.$products_per_page.'';
  }

  return $sql;

} 



function sort_sql($query, $district, $color) {
  $output = '';

  $output .= '<a class="price-u" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'&color='.$color.'&sorttype=Price&sortby=Asc">價格 ⇧</a>';
  $output .= '<a class="price-d" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'&color='.$color.'&sorttype=Price&sortby=Desc">價格 ⇩</a>';
  $output .= '<a class="date-u" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'&color='.$color.'&sorttype=Date&sortby=Asc">日期 ⇧</a>';
  $output .= '<a class="date-d" href="https://www.gaakzei.com/search/search?ct=Products&query='.$query.'&page=1&district='.$district.'&color='.$color.'&sorttype=Date&sortby=Desc">日期 ⇩</a>';

  return $output;
}

function get_sort($default) {

  if (!isset($_GET['sorttype']) || !isset($_GET['sortby'])) {
    $output = 'ORDER BY '.$default.' DESC';
    return $output;

  } else {
    $type = varify_query($_GET['sorttype']);
    $sortby = varify_query($_GET['sortby']);

    if ($type == 'Price') {
      $column = 'goodsPrice';
    } elseif ($type == 'Date') {
      $column = 'goodsID';
    }

    if ($sortby == 'Asc') {
      $sort_order = ' ASC';
    } elseif ($sortby == 'Desc') {
      $sort_order = ' DESC';
    }

    return 'ORDER BY '.$column.$sort_order;
  }
}


function play_ads($i) {
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