<?php
    session_start();

    require '../INCLUDES/dbh.inc.php';
    require '../INCLUDES/header.php';
    require 'search.inc.php';
    require '../security/view.inc.php';
    security();

    /* function */
    function check_type($input) {
      if ($_GET['ct'] == 'Products') {
        return $input;
      } else {
        return '';
      }
    }
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>GaakZei-Search</title>

    <link rel="stylesheet" href="css/pagination-button-1029.css">
  	<link rel="stylesheet" href="css/search-0118a.css">
    <link rel="stylesheet" href="css/user-info-1104.css">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/search-like1219.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  </head>
  <body>

    <?php 
    if ($_GET['ct'] != 'Products') {

    } else {
        echo '<div class="filter-main-container">

              <div class="filter-title-container">
                <p class="filter-title">所有分類</p>

                <div class="reset">
                  '.$district_cancel_output.'
                </div>

              </div>

              <div class="filter-container">
                <div class="filter-item">
                '.$district_output.'
                </div>
                <div class="filter-item">
                '.$color_output.'
                </div>
              </div>
            </div>';
    }

    ?>

    <div class="latest-products-container">

      <div class="latest-products-title-container">
        <h1 class="latest-products-title"><?php echo $search ?> 的搜尋結果  <span class="total-Product"> (<?php echo $number_of_result;?>)
          </span>
          <div class="fourinone">
            <div class="filter-item">
              <?php echo check_type($sort_output);?>
            </div>
          </div>
        </h1>
      
      </div>

      <div class="latest-products-conte-ntcontainer">
        <ul class="latest-product-ul">
          <?php
            echo $output;
           ?>
        </ul>
      </div>
      <div class="pagination-button">
        <?php
          echo $pagination;
        ?>
      </div>
    </div>
   
    <div style="text-align: center; margin-top: 25px;">
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- banner -->
      <ins class="adsbygoogle"
          style="display:block"
          data-ad-client="ca-pub-8589551961577205"
          data-ad-slot="6284584390"
          data-ad-format="auto"
          data-full-width-responsive="true"></ins>
      <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
   </div>



  </body>
</html>


<?php
    require '../INCLUDES/footer.php';
   ?>