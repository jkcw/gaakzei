<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  require '../../INCLUDES/dbh.inc.php';
  require 'user-session.php';
  require 'img-loop.inc.php';

  include '../../security/product-record.inc.php';
  productRecord($goodsIDp);


  if (isset($_SESSION['uid'])) {
    $session = $_SESSION['uid'];

  } else {
    $session = 0;
  }

  require 'productFILE-views-count.inc.php';
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">

    <meta name="KeyWords" content="gaakzei'格仔'格仔鋪'<?php echo $uidUsers; ?>">
    <meta name="Description" content="<?php echo $goodsContent; ?>">
    <meta name="Author" content="GaakZei">
    <meta name="Creation-Date" content="<?php echo $goodsUploadDate; ?>">
    <meta HTTP-EQUIV="Pragma" content="no-cache">
    <meta http-equiv="refresh" content="300">

    <title><?php echo $goodsTitle; ?></title>
    <link rel="shortcut icon" type="image/GIF" href="//localhost/GaakZei/system-img/GK_icon.gif"/>
  </head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"><!--cdn-->
  <link rel="stylesheet" href="css/product-page1127.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/user-product.js"></script>
  <script type="text/javascript" src="js/user-comment-new.js"></script>
  <script type="text/javascript" src="js/img-slider.js"></script>
  <script type="text/javascript" src="js/comment-img-upload.js"></script>
  <script type="text/javascript" src="js/comment-form-slide-down.js"></script>
  <script type="text/javascript" src="js/comment-img-hide.js"></script>
  <script type="text/javascript" src="js/comment-img-popup.js"></script>
  <script type="text/javascript" src="js/comment-load-more.js"></script>

  <body>

    <?php
    if (isset($_GET['success'])) {
      if ($_GET['success'] == 'key') {
        echo '<h1 class="system-message">已成功更改關鍵字</h1>';
      }
    }

      /*check session*/
      if ($session == $userIDp) {
        $output = '<form class="edit-form" action="https://www.gaakzei.com/edit/product-edit/product-edit?gid='.$goodsIDp.'" method="post">
                    <button class="edit-button" type="submit" name="edit-product">編輯商品資料</button>
                   </form>';
      } else {
        $output = '';
      }
     ?>

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

    <div class="main-container">



      <div class="upper-container">
        <div class="img-container">
          <section id="img-slider-section">
            <div class="slider-container">
              <div id="slider">
                <?php
                  echo $image_output;

                 ?>
              </div>
              <?php echo $img_button; ?>
            </div>
          </section>

          <div class="views-container">
            <p class="count-views-p"><?php echo $totalViews; ?></p>
            <p class="count-views-p"><?php echo $viewsToday; ?></p>
          </div>

        </div>




        <div class="upper-right-container">
          <a href="https://www.gaakzei.com/user-info/<?php echo $userIDp; ?>-profile">
            <div class="user-info-container">
              <div class="user-icon-container">
                <?php echo $icon_output; ?>
              </div>
              <div class="user-info-text-div">
                <div class="user-info-text">
                  <p class="info-text-username"><?php echo $uidUsers; ?></p>
                </div>
                <div class="user-info-text">
                  <p class="info-text">ID：<?php echo $userIDp; ?></p>
                </div>
              </div>
            </div>
          </a>



          <div class="product-info-container">

            <div class="product-info-text-div">
              <h1 class="product-title"><?php echo $goodsTitle; ?></h1>
            </div>

            <div class="info-bar">
              <div class="porduct-id-div">
                <p class="product-id">商品ID：<?php echo $goodsIDp; ?></p>
              </div>
              <div class="like-div">
                <?php
                require 'user-like.inc.php';
                echo $like_output;
                ?>
              </div>
            </div>

            <div class="product-info-text-div">
              <h2 class="product-info-text"><img class="info-icon" src="system-svg/date.svg" /> <?php echo $goodsUploadDate; ?></h2>
            </div>

            <div class="product-info-text-div">
              <h2 class="product-info-text"><img class="info-icon" src="system-svg/location.svg" /> <?php echo $goodsAddress; ?></h2>
            </div>

            <div class="product-info-text-div">
              <h2 class="product-info-text"><img class="info-icon" src="system-svg/price.svg" /> HKD <?php echo $goodsPrice; ?>（每件）</h2>
            </div>

            <div class="product-info-text-div">
              <h2 class="product-info-text"><img class="info-icon" src="system-svg/weight.svg" /> <?php echo $goodsWeightG; ?>gram</h2>
            </div>

            <div class="product-info-text-div">
              <h2 class="product-info-text"><img class="info-icon" src="system-svg/color.svg" /> <?php echo $goodsColor; ?></h2>
            </div>

            <div class="product-info-text-div">
              <a class="contact-a" href="https://www.gaakzei.com/user-info/<?php echo $userIDp; ?>-profile">
                <h2 class="product-info-text-a"><img class="info-icon" src="system-svg/contact.svg" /> <?php echo $goodsPhone; ?></h2>
              </a>
            </div>

            <div class="refill-container">
              <div class="product-info-text-div">
                <h2 class="stock-text">最近一次補貨日期：<?php echo $date[0]; ?></h2>
              </div>

              <div class="product-info-text-div-second">
                <h2 class="stock-text">最近一次補貨數量：<?php echo $goodsQuantity; ?>（此數據只供參考）</h2> <br>
              </div>
            </div>

            <div class="product-info-edit-div">
              <?php echo $output; ?>
            </div>
          </div>
        </div>

      </div>


      <div class="product-details-container">
        <div class="details-title-div">
          <h3 class="details-title-h3">商品詳情</h3>
        </div>
        <div class="details-article-div">
          <article class="details-article">
            <p class="details-p"><?php echo $goodsContent; ?></p>
          </article>
        </div>
      </div>

      <div class="comment-input-div">

        <div class="comment-title-div">
            <p class="comment-title-p">滿意度及評價</p>
        </div>

        <div class="rating-container">

            <form method="post" enctype="multipart/form-data" action="include/user-comment-upload.inc.php">

              <div class="rating-icon-div">
                <label for="super-sad">
                <input type="radio" name="rating" class="super-sad" id="super-sad" value="0" />
                <svg class="rating-svg" viewBox="0 0 24 24"><path d="M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M16.18,7.76L15.12,8.82L14.06,7.76L13,8.82L14.06,9.88L13,10.94L14.06,12L15.12,10.94L16.18,12L17.24,10.94L16.18,9.88L17.24,8.82L16.18,7.76M7.82,12L8.88,10.94L9.94,12L11,10.94L9.94,9.88L11,8.82L9.94,7.76L8.88,8.82L7.82,7.76L6.76,8.82L7.82,9.88L6.76,10.94L7.82,12M12,14C9.67,14 7.69,15.46 6.89,17.5H17.11C16.31,15.46 14.33,14 12,14Z" /></svg>
                </label>

                  <label for="sad">
                <input type="radio" name="rating" class="sad" id="sad" value="25" />
                <svg class="rating-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M15.5,8C16.3,8 17,8.7 17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M12,14C13.75,14 15.29,14.72 16.19,15.81L14.77,17.23C14.32,16.5 13.25,16 12,16C10.75,16 9.68,16.5 9.23,17.23L7.81,15.81C8.71,14.72 10.25,14 12,14Z" /></svg>
                </label>

                  <label for="neutral">
                <input type="radio" name="rating" class="neutral" id="neutral" value="50" />
                <svg class="rating-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M8.5,11A1.5,1.5 0 0,1 7,9.5A1.5,1.5 0 0,1 8.5,8A1.5,1.5 0 0,1 10,9.5A1.5,1.5 0 0,1 8.5,11M15.5,11A1.5,1.5 0 0,1 14,9.5A1.5,1.5 0 0,1 15.5,8A1.5,1.5 0 0,1 17,9.5A1.5,1.5 0 0,1 15.5,11M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M9,14H15A1,1 0 0,1 16,15A1,1 0 0,1 15,16H9A1,1 0 0,1 8,15A1,1 0 0,1 9,14Z" /></svg>
                </label>

                  <label for="happy">
                <input type="radio" name="rating" class="happy" id="happy" value="80" checked />
                <svg class="rating-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100%" height="100%" viewBox="0 0 24 24"><path d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" /></svg>
                </label>

                  <label for="super-happy">
                <input type="radio" name="rating" class="super-happy" id="super-happy" value="100" />
                <svg class="rating-svg" viewBox="0 0 24 24"><path d="M12,17.5C14.33,17.5 16.3,16.04 17.11,14H6.89C7.69,16.04 9.67,17.5 12,17.5M8.5,11A1.5,1.5 0 0,0 10,9.5A1.5,1.5 0 0,0 8.5,8A1.5,1.5 0 0,0 7,9.5A1.5,1.5 0 0,0 8.5,11M15.5,11A1.5,1.5 0 0,0 17,9.5A1.5,1.5 0 0,0 15.5,8A1.5,1.5 0 0,0 14,9.5A1.5,1.5 0 0,0 15.5,11M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" /></svg>
                </label>
              </div>

            <div class="textarea-img-container">
              <!--img upload-->
               <div class="comment-fileupload-div">
                 <ul class="img_ul">
                   <?php
                   require 'include/comment-img-upload-loop.php';
                   echo $img_output;
                   ?>
                 </ul>
               </div>

               <div class="comment-textarea-div">
                 <textarea class="comment-textarea" id="comment-textarea" minlength="25" maxlength="200" name="comment-text" rows="8" cols="80" required></textarea>
               </div>
            </div>

              <input type="hidden" id="score" name="score" value=""/>
              <input type="hidden" id="goodsID" name="goodsID" value='<?php echo $goodsIDp; ?>'/>
              <input type="hidden" id="uid" name="uid" value='<?php echo $uid; ?>'/>
              <input type="hidden" id="owner-uid" name="o-uid" value='<?php echo $userIDp; ?>'/>

              <div class="comment-form-submit-div">
                <button class="comment-form-submit-button" type="click" name="comment-submit" id="comment-submit" value="<?php echo $session; ?>">提交</button>
              </div>

            </form>

            <div class="comment-warning-div">
              <h3 class="comment-warning">請注意！你只可以對此產品進行一次評價。詳情請參考
                <a class="comment-warning-a" href="https://www.gaakzei.com/consent/rating-guidelines">《評價指南》</a>
              </h3>
            </div>

        </div>
      </div>

      <div class="mid-ad">
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
      
    <?php require 'comment-load.inc.php'; ?>

    <div class="prev-comment-container">
      <div class="prev-comment-main-title-div">
        <p class="prev-comment-main-title">過往評價 (<?php echo $total_comment; ?>)</p>
        <a href="https://www.gaakzei.com/consent/rating-guidelines.html">
          <p class="prev-comment-main-title-avg">平均<?php echo $score_output; ?></p>
        </a>
      </div>
      <div class="prev-comment-container-childDIV">
        <?php
          echo $comment_output;
        ?>
      </div>
      <?php echo $comment_output_button; ?>
    </div>


</div>



  </body>
</html>
