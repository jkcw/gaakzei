<?php
  session_start();
  require '../security/view.inc.php';
  security();

  if (!isset($_SESSION['usersEmail'])) {
    header("Location: https://www.gaakzei.com/INCLUDES/login?error=nologin");
  }
    require "../INCLUDES/header.php";
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>商品上傳</title>
    <link rel="stylesheet" href="css/goods-upload1127.css">
  </head>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
  <script src="goods-upload1128a.js" type="text/javascript"></script>
  <script src="https://www.gaakzei.com/INCLUDES/ckeditor/ckeditor.js" type="text/javascript"></script>
  <script src="goods-upload-img1127a.js" type="text/javascript"></script>

  <body>
      <!--Alert of Error-->
      <?php
      if (isset($_GET['error'])) {

      if ($_GET['error'] == 'empty') {
        echo '<p class="system-message">請確保已輸入所有表單！</p>';
      }
      elseif ($_GET['error'] == 'title2long') {
        echo '<p class="system-message">標題不能超過60個字符或20個中文字</p>';
      }
      elseif ($_GET['error'] == 'content2long') {
        echo '<p class="system-message">貨品不能超過750個字符或250個中文字</p>';
      }
      elseif ($_GET['error'] == 'address2long') {
        echo '<p class="system-message">地址不能超過60個字符或20個中文字</p>';
      }
      elseif ($_GET['error'] == 'price0') {
        echo '<p class="system-message">價格不能夠為零，或負數</p>';
      }
      elseif ($_GET['error'] == 'weight0') {
        echo '<p class="system-message">重量不能夠為零，或負數</p>';
      }
      elseif ($_GET['error'] == 'quantity0') {
        echo '<p class="system-message">數量不能夠為零，或負數</p>';
      }
      elseif ($_GET['error'] == 'colour2long') {
        echo '<p class="system-message">顔色不能超過15個字符或5個中文字</p>';
      }
      elseif ($_GET['error'] == 'kywempty') {
      echo '<p class="system-message">請確保輸入所有表單，關鍵字能夠使用戶更容易地找到你的產品。</p>';
      }
      elseif ($_GET['error'] == 'kyw2long') {
        echo '<p class="system-message">關鍵字不能超過6個中文字，或18個字符</p>';
      }
      elseif ($_GET['error'] == 'img8') {
        echo '<p class="system-message">貨品圖片不能多於8張</p>';
      }
      elseif ($_GET['error'] == 'picsFile') {
        echo '<p class="system-message">圖片格式必須為 JPG 或 JPEG 或 PNG 或 PDF</p>';
      }
      elseif ($_GET['error'] == 'uploadError') {
        echo '<p class="system-message">圖片上傳出現錯誤，請重試</p>';
      }
      elseif ($_GET['error'] == 'file2big') {
        echo '<p class="system-message">圖片檔案過大，每張圖片檔案大小必須小於 1.5MB</p>';
      }
      elseif ($_GET['error'] == 'fileTmpError') {
        echo '<p class="system-message">圖片上傳出現錯誤，請先重試。或者請聯絡客服部門 gaakzei@gmail.com</p>';
      }
      elseif ($_GET['error'] == 'sqlerror') {
        echo '<p class="system-message">系統出現問題，請先重試。或者請聯絡客服部門 gaakzei@gmail.com</p>';
      }
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

    <div class="goods-upload-heading">
      <h1 class="main-heading">商品上傳</h1>
    </div>
    
    <div class="main-container">

      <div class="form-container">
        <form action = "includes/goods-upload.inc.php" method = "post" enctype="multipart/form-data">

          <div class="profile-edit-img">
              <p class="img-uploader-text">圖片上傳</p>
            <ul class="img_ul">
              <?php
              require 'img-output.inc.php';
              echo $img_output ?>
            </ul>
              <p class="img-uploader-text">*只限.JPG, JPEG, PNG, GIF</p>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>商品標題</p>
            </div>
            <div class="input-div-details">
              <input type="text" name="goodsTitle" placeholder="商品標題" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>商品内容</p>
            </div>
            <div class="input-div-ckeditor">
              <textarea id="content" class="ckeditor" name="goodsContent" rows="8" cols="50" required></textarea>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>地址（格仔舖）</p>
            </div>
            <div class="input-div-details">
              <div class="district-address">
                <div class="address">
                  <input id="goodsAddress" type="text" name="goodsAddress" placeholder="地址（格仔舖）" required>
                </div>
                <select id="select" class="district" name="district" required>
                  <option value="hk" disabled>香港島 Hong Kong Island</option>
                  <option value="中西區">中西區 Central and Western</option>
                  <option value="灣仔區">灣仔區 Wan Chai</option>
                  <option value="東區">東區 Eastern</option>
                  <option value="南區">南區 Southern</option>

                  <option value="kl" disabled>九龍 Kowloon</option>
                  <option value="油尖旺區">油尖旺區 Yau Tsim Mong</option>
                  <option value="深水埗區">深水埗區 Sham Shui Po</option>
                  <option value="九龍城區">九龍城區 Kowloon City</option>
                  <option value="黃大仙區">黃大仙區 Wong Tai Sin</option>
                  <option value="觀塘區">觀塘區 Kwun Tong</option>

                  <option value="nt" disabled>新界</option>
                  <option value="葵青區">葵青區 Kwai Tsing</option>
                  <option value="荃灣區">荃灣區 Tsuen Wan</option>
                  <option value="屯門區">屯門區 Tuen Mun</option>
                  <option value="元朗區">元朗區 Yuen Long</option>
                  <option value="北區">北區 North</option>
                  <option value="大埔區">大埔區 Tai Po</option>
                  <option value="沙田區">沙田區 Sha Tin</option>
                  <option value="西貢區">西貢區 Sai Kung</option>
                  <option value="離島區">離島區 Islands</option>

                </select>
              </div>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>聯絡電話</p>
            </div>
            <div class="input-div-details">
              <input type="number" name="phone" min="10000000" max="99999999" placeholder="聯絡電話" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>價格</p>
            </div>
            <div class="input-div-details">
              <input type="number" min="0" step="0.1" name="goodsPrice" placeholder="商品價格" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>重量</p>
            </div>
            <div class="input-div-details">
              <input type="number" min="0" name="goodsWeight" placeholder="gram(g)" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>顔色</p>
            </div>
            <div class="input-div-details">
              <input type="text" name="goodsColour" placeholder="顔色" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>最近入貨量</p>
            </div>
            <div class="input-div-details">
              <input type="number" min="0" name="goodsRefillQuantity" placeholder="數量" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">

            <div class="heading-input-details">
              <p>關鍵字1</p>
            </div>
            <div class="input-div-details">
              <input type="text" name="keyword1" placeholder="#" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>關鍵字2</p>
            </div>
            <div class="input-div-details">
              <input type="text" name="keyword2" placeholder="#" required>
            </div>
          </div>

          <div class="profile-edit-details-form-div">
            <div class="heading-input-details">
              <p>關鍵字3</p>
            </div>
            <div class="input-div-details">
              <input type="text" name="keyword3" placeholder="#" required>
            </div>
          </div>

          <div class="details-button">
            <button type="submit" name="submit" class="update-details-submit">上傳</button>
          </div>
          
                    <script type='text/javascript'>
                    var editor = CKEDITOR.replace( 'goodsContent', {
                             language: 'zh',
                             extraPlugins: 'notification'
                          });

                          editor.on( 'required', function( evt ) {
                             editor.showNotification( '請輸入商品内容！', 'warning' );
                             evt.cancel();
                          } );
                    </script>
                    <script type="text/javascript">
                      $(document).ready(function() {
                        $(".district").chosen();
                      });
                    </script>
              </form>
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
      
  </body>

  <?php
    require '../INCLUDES/footer.php';
   ?>

</html>
