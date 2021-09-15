<?php
    session_start();
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    function show_ads($i) {
      $num = $i%8;
      if ($num == 0) {
        return '<div class="mid-ad" style="text-align:center;">
                  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                  <!-- banner slight -->
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
    
    require 'INCLUDES/header.php';
    require 'INCLUDES/dbh.inc.php';
    require 'INCLUDES/include/latest-products.inc.php';
    require 'INCLUDES/include/count-products-views.inc.php';
    require 'INCLUDES/include/sponsored-products.inc.php';
    require 'security/view.inc.php';
    security();

    if (isset($_GET['error'])) {

      if ($_GET['error'] == 'sql' || $_GET['error'] == 'sqlerror') {
        $system_output = '<p class="system-message">系統錯誤，請重試 INDEXSQL</p>';

      } elseif ($_GET['error'] == 'sqlerrorverify') {
        $system_output = '<p class="system-message">系統錯誤，請重試 INDEXSQL</p>';

      } elseif ($_GET['error'] == 'sqlerrornotverify') {
        $system_output = '<p class="system-message">不好意思,你的賬戶尚未驗證，請檢查Email郵箱。如遇到問題請聯絡客服部門 gaakzei@gmail.com</p>';
      }
    } else {
      $system_output = '';
    }

    if (isset($_GET['success'])) {

      if ($_GET['success'] == 'login') {
        $system_output = '<p class="system-message">已成功登入，歡迎使用GaakZei！</p>';

      } elseif ($_GET['success'] == 'signupsuccess') {
        $system_output = '<p class="system-message">已成功註冊及激活，現在可以登入,歡迎使用GaakZei!</p>';

      } elseif ($_GET['success'] == 'uploaded') {
        $system_output = '<p class="system-message">貨品已成功上傳！</p>';

      } elseif ($_GET['success'] == 'logout') {
        $system_output = '<p class="system-message">已成功登出！</p>';

      }
    }

    if (isset($_GET['newpwd'])) {
      if ($_GET['newpwd'] == 'pwdupdated') {
        $system_output = '<p class="system-message">已成功重設密碼，現在可以登入，歡迎使用GaakZei！</p>';
      }
    }
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

     <meta name="KeyWords" content="gaakzei'格仔'格仔鋪">
     <meta name="Description" content="香港大型格仔鋪資訊提供平台，提供多元化的商品及格仔鋪資訊，包括價格、存貨、詳細規格、用戶評價及相關情報等，並設有全面既嚴謹的用戶評價系統，采用新穎的創意與科技，向用戶提供可靠的格仔鋪資訊。">
     <meta name="Author" content="GaakZei">
     <meta HTTP-EQUIV="Pragma" content="no-cache">
     <meta http-equiv="refresh" content="300">

    <title>GaakZei-香港格仔網-香港首個大型網上格仔鋪資訊提供平台</title>
    <link rel="stylesheet" href="INCLUDES/css/index1205.css">
    <link rel="shortcut icon" type="image/x-icon" href="INCLUDES/GK_icon.GIF"/>
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="INCLUDES/js/index-like-sss.js"></script>
    <script type="text/javascript" src="INCLUDES/js/index-banner-813.js"></script>
    <script type="text/javascript" src="INCLUDES/js/show-ads.js"></script>

    <link rel="shortcut icon" type="image/GIF" href="https://www.gaakzei.com/system-img/GK_icon.gif"/>

  </head>


  <body>
    <h1><?php echo $system_output; ?></h1>

    <div class="main-contaienr">
    
      <div class="head-ad" style="text-align:center;">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- banner slight -->
        <ins class="adsbygoogle"
            style="display:inline-block;width:728px;height:90px"
            data-ad-client="ca-pub-8589551961577205"
            data-ad-slot="3048224575"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>

      <div class="upper-container">

        <div class="upper-left-container" id="upper-left-container">

          <div class="img-bank-btn img-bank-btn-prev" id="img-bank-btn-prev"></div>

          <div class="banner" id="ban3">

          </div>

          <div class="banner" id="ban2">

          </div>

          <div class="banner" id="ban1">

          </div>

          <div class="img-bank-btn img-bank-btn-next" id="img-bank-btn-next"></div>

        </div>

        <div class="upper-right-container">
          <div class="upper-right-container-title-div">
            <h1 class="upper-right-container-title">GaakZei</h1>
          </div>

        <hr class="upper-right">

          <div class="up-right-text">
            <p style="text-align:left;">親愛的Gaakzei用戶 您好</p>

            <p style="text-align:left;">Gaakzei 香港格仔網 v1.0 正式上線，歡迎各位大駕光臨</p>
  
            <p style="text-align:right;">Gaakzei 營運團隊 敬上</p>
          </div>

        </div>
      </div>

      <div class="catergories-container">

        <div class="catergories-title-container">
          <h1 style="display:none;">格仔鋪</h1>
          <h2 class="catergories-title-p">熱門分類</h2>
        </div>
        <?php

         ?>
        <div class="catergories-content-container">

          <a class="cate-a" href="https://www.gaakzei.com/search/search?ct=Products&query=slime+鬼口水&page=1">
            <div class="catergories">

              <div class="cate-img-div">
                <img class="cate-img" src="https://www.gaakzei.com/system-img/cate-slime.jpg">
              </div>
              <div class="cate-content">
                <h1 class="cate-content-p">Slime 鬼口水</h1>
              </div>

            </div>
          </a>

          <a class="cate-a" href="https://www.gaakzei.com/search/search.php?ct=Products&query=jewellery+首飾&page=1">
            <div class="catergories">

              <div class="cate-img-div">
                <img class="cate-img" src="https://www.gaakzei.com/system-img/cate-jewellery.jpg">
              </div>
              <div class="cate-content">
                <h1 class="cate-content-p">首飾</h1>
              </div>

            </div>
          </a>

          <a class="cate-a" href="https://www.gaakzei.com/search/search.php?ct=Products&query=squishies&page=1">
            <div class="catergories">

              <div class="cate-img-div">
                <img class="cate-img" src="https://www.gaakzei.com/system-img/cate-squishies.jpg">
              </div>
              <div class="cate-content-container">
                <h1 class="cate-content-p">Squishies</h1>
              </div>

            </div>
          </a>

          <a class="cate-a" href="https://www.gaakzei.com/search/search.php?ct=Products&query=化妝品+cosmetic&page=1">
            <div class="catergories">

              <div class="cate-img-div">
                <img class="cate-img" src="https://www.gaakzei.com/system-img/cate-cosmetic.jpg">
              </div>
              <div class="cate-content-container">
                <h1 class="cate-content-p">化妝品</h1>
              </div>

            </div>

          </div>
        </a>
      </div>

      <div class="recommended-products-container">

        <div class="recommended-products-title-container">
          <h2 class="recommended-products-title">今日最HIT
            <span class="flame-span"><img class="flame-img" src="https://www.gaakzei.com/system-img/flame.svg" /></span>
          </h2>
        </div>

        <div class="hot-sponsored-container">

          <div class="hot-products-content-container">
            <?php echo $hot_pd_output; ?>
          </div>

          <div class="sponsored-products-content-container">
            <?php echo $sponsored_pd_output; ?>
          </div>

        </div>


      </div>

      <div class="mid-ad" style="text-align:center;">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- banner slight -->
        <ins class="adsbygoogle"
            style="display:inline-block;width:728px;height:90px"
            data-ad-client="ca-pub-8589551961577205"
            data-ad-slot="3048224575"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
      


      <div class="latest-products-container">

        <div class="latest-products-title-container">
          <h2 class="latest-products-title">最新商品</h2>
        </div>

        <div class="latest-products-content-container">
          <ul class="latest-product-ul">
            <?php
              require 'INCLUDES/include/latest-products.inc.php';
              echo $latest_product_output;
             ?>
          </ul>
        </div>

      </div>

      <div class="mid-ad" style="text-align:center;">
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

    </div>
    </div>

  
    



  </body>

  <?php
    require 'INCLUDES/footer.php';
   ?>
</html>
