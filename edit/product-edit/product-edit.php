<?php
  session_start();

  require '../../INCLUDES/header.php';
  require '../../INCLUDES/dbh.inc.php';
  require 'session.inc.php';
  require '../edit-security/view.inc.php';
  security();
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>編輯商品</title>
  </head>

  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://www.gaakzei.com/INCLUDES/ckeditor/ckeditor.js" type="text/javascript"></script>
  <script src="product-edit1208.js" type="text/javascript"></script>
  <script src="product-img-edit1208.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">

    <link rel="stylesheet" type="text/css" href="css/product-edit-1112.css">

  <body>
    <?php
      if (isset($_GET['error'])) {
        if ($_GET['error'] == 'format') {
          echo '<p class="error-message">圖片格式必須為 JPG 或 JPEG 或 PNG 或 PDF</p>';
        } elseif ($_GET['error'] == 'file2big') {
          echo '<p class="error-message">圖片檔案過大，每張圖片檔案大小必須小於 1.5MB</p>';
        } elseif ($_GET['error'] == 'fileTmpError') {
          echo '<p class="error-message">圖片上傳出現錯誤，請重試</p>';
        }
      }
    ?>
    <div class="product-edit-heading">
      <h1>編輯商品</h1>
      <h3>商品編號：<?php echo $productID; ?></h3>
    </div>

      <p id="quantity" value="<?php echo $goodsIMG;?>"></p>
      <?php
        require 'product-img-loop.inc.php';
      ?>

      <div class="p-e-container">

    <div class="product-edit-details-container">

      <div class="product-edit-details-heading">
        <h2>編輯商品資料</h2>
      </div>

      <form id="ckeditor" class="details-form" action="product-edit.inc.php" method="post" enctype="multipart/form-data">

        <div class="profile-edit-img">
          <ul class="img_ul">
            <?php echo $img_output ?>
          </ul>

          <input type="hidden" id="delete-check" name="delete-check" value=""></input>
        </div>

        <div class="profile-edit-details-form-div">
          <div class="heading-input-details">
            <p>商品標題</p>
          </div>
          <div class="input-div-details">
            <input id="goodsTitle" type="text" name="goodsTitle" value="<?php echo $goodsTitle;?>" placeholder="商品標題" required>
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
                <input id="goodsAddress" type="text" name="goodsAddress" value="<?php echo $goodsAddress;?>" placeholder="地址（格仔舖）" required>
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
            <input id="goodsPhone" type="number" min="10000000" max="99999999" name="goodsPhone" value="<?php echo $goodsPhone;?>" placeholder="聯絡電話" required>
          </div>
        </div>

        <div class="profile-edit-details-form-div">
          <div class="heading-input-details">
            <p>價格</p>
          </div>
          <div class="input-div-details">
            <input id="goodsPrice" type="number" min="0.1" max="99999" step="0.1" name="goodsPrice" value="<?php echo $goodsPrice;?>" placeholder="價格" required>
          </div>
        </div>

        <div class="profile-edit-details-form-div">
          <div class="heading-input-details">
            <p>重量</p>
          </div>
          <div class="input-div-details">
            <input id="goodsWeightG" type="number" min="0.1" max="99999" step="0.1" name="goodsWeightG" value="<?php echo $goodsWeightG;?>" placeholder="重量" required>
          </div>
        </div>

        <div class="profile-edit-details-form-div">
          <div class="heading-input-details">
            <p>顔色</p>
          </div>
          <div class="input-div-details">
            <input id="goodsColor" type="text" name="goodsColor" value="<?php echo $goodsColor;?>" placeholder="顔色" required>
          </div>
        </div>

        <div class="profile-edit-details-form-div">
          <div class="heading-input-details">
            <p>最近入貨量</p>
          </div>
          <div class="input-div-details">
            <input id="goodsQuantity" type="number" min="1" max="1000" name="goodsQuantity" value="<?php echo $Quantity;?>" required>
          </div>
        </div>

        <input type="hidden" name="pid" value="<?php echo $productID;?>">
        <input type="hidden" name="uid" value="<?php echo $uid;?>">

        <div class="details-button">
          <button class="update-details-submit" type="submit" name="button-data">修改資料</button>
        </div>

      </form>
      <script type="text/javascript">
        $(document).ready(function() {
          $(".district").chosen();
        });
      </script>

  </div>

    <div class="keywords-container">

      <div class="kw-heading">
        <h2>編輯商品關鍵字</h2>
      </div>

      <form class="" action="keyword-edit.inc.php" method="post">
        <div class="keywords-input-div">
          <div class="keywords-input-heading-div">
            <p>關鍵字1</p>
          </div>
          <div class="keywords-input-div-div">
            <input type="text" name="ky1" value="<?php echo $ky1;?>" placeholder="<?php echo $ky1;?>" required>
          </div>
        </div>

        <div class="keywords-input-div">
          <div class="keywords-input-heading-div">
            <p>關鍵字2：</p>
          </div>
          <div class="keywords-input-div-div">
            <input type="text" name="ky2" value="<?php echo $ky2;?>" placeholder="<?php echo $ky2;?>" required>
          </div>
        </div>

        <div class="keywords-input-div">
          <div class="keywords-input-heading-div">
            <p>關鍵字3：</p>
          </div>
          <div class="keywords-input-div-div">
            <input type="text" name="ky3" value="<?php echo $ky3;?>" placeholder="<?php echo $ky3;?>" required>
          </div>
        </div>

        <input type="hidden" name="pid-ky" value="<?php echo $productID;?>">
        <input type="hidden" name="uid-ky" value="<?php echo $uid;?>">

        <div class="keywords-button">
          <button class="keywords-button-submit" type="submit" name="ky-button">修改關鍵字</button>
        </div>

      </form>
    </div>
   </div>
  </body>
</html>
