<?php
  session_start();
  require '../../INCLUDES/dbh.inc.php';
  require '../../INCLUDES/header.php';
  require 'session.inc.php';
  require '../edit-security/view.inc.php';
  security();
 ?>
<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>編輯個人檔案</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="check-pwd.js"></script>
    <script src="https://www.gaakzei.com/INCLUDES/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/icon-preview.js"></script>
    <link rel="stylesheet" href="css/profile-edit-1201a.css">
  </head>

  <body>
<?php
  if (isset($_GET['error'])) {
    if ($_GET['error'] == 'nsession') {
      echo '<h2 class="system-message">請先登入</h2>';
    } elseif ($_GET['error'] == 'nsd') {
      echo '<h2 class="system-message">請再試一次</h2>';
    } elseif ($_GET['error'] == 'empty') {
      echo '<h2 class="system-message">請至少更改一項資料（無需更改的資料只需漏空即可）</h2>';
    } elseif ($_GET['error'] == 'sql') {
      echo '<h2 class="system-message">請再試一次，或聯絡客服部門，謝謝</h2>';
    } elseif ($_GET['error'] == 'pwdWrong') {
      echo '<h2 class="system-message">不好意思，你輸入的密碼不正確</h2>';
    } elseif ($_GET['error'] == 'format') {
      echo '<h2 class="system-message">圖片格式必須為 JPG 或 JPEG 或 PNG 或 PDF</h2>';
    } elseif ($_GET['error'] == 'uploadError') {
      echo '<h2 class="system-message">圖片上傳出現錯誤，請重試</h2>';
    } elseif ($_GET['error'] == 'file2big') {
      echo '<h2 class="system-message">圖片檔案過大，每張圖片檔案大小必須小於 1.5MB</h2>';
    } elseif ($_GET['error'] == 'duplicate') {
      echo '<h2 class="system-message">用戶名已被使用，請重新再試</h2>';
    } elseif ($_GET['error'] == 'dateUsr') {
      echo '<h2 class="system-message">不好意思，用戶名只能每兩天更改一次</h2>';
    }

  } elseif (isset($_GET['success'])) {
    if ($_GET['success'] == 'success') {
      echo '<h2 class="system-message">恭喜，已成功更改資料！</h2>';
    } elseif ($_GET['success'] == 'pwd') {
      echo '<h2 class="system-message">恭喜，已成功更改密碼！</h2>';
    } elseif ($_GET['success'] == 'username') {
      echo '<h2 class="system-message">恭喜，已成功更改用戶名！</h2>';
    }
  }
 ?>

  <div class="profile-edit-heading">
    <h1>編輯用戶資料</h1>
    <h3>用戶ID：<?php echo $idusers;?></h3>
  </div>

  <div class="main-edit-wrapper">

      <div class="container-icon">
          <?php echo icon_status($usersIcon, $idusers); ?>
          <form class="" action="change-icon.inc.php" method="post" enctype="multipart/form-data" id="iconUploadForm">
            <label for="icon_file" class="icon-form-label">更改</label>
            <input class="input-icon" type="file" name="icon_file" id="icon_file">
            <button onclick="myFunction()" class="icon-button" type="submit" name="icon_file_submit">確定</button>
          </form>
        <p>*只限.JPG, JPEG, PNG, GIF</p>
      </div>

      <div class="container-username">
        <div class="username-title-div">
          <h3 class="username-title">更改用戶名</h3>
        </div>
        <form class="" action="includes/change-username.inc.php" method="post">
          <input class="input-username" type="text" name="input-username" require>
          <input type="hidden" name="username-userID" value="<?php echo $idusers;?>"><br>
          <button class="username-button" type="submit" name="username_submit">提交</button>
        </form>
      </div>

      <div class="cointainer-details-edit">
        <form class="form-details-edit" action="profile-edit.inc.php" method="post">

          <div class="details-input-group">
            <b class="details-p">商舖名稱</b>
            <input class="details-input" id="userShopN" type="text" name="userShopN" placeholder="<?php echo $userShopN;?>" value="<?php echo $userShopN;?>" required>
          </div>

          <div class="details-input-group">
            <b class="details-p">查詢電話</b>
            <input class="details-input" id="userPhoneN" type="number" min="10000000" max="99999999" name="userPhoneN" placeholder="<?php echo $userPhoneN;?>" value="<?php echo $userPhoneN;?>" required>
          </div>

          <div class="details-input-group">
            <b class="details-p">電郵地址</b>
            <input class="details-input" id="userContectEmail" type="email" name="userContactEmail" placeholder="<?php echo $userContactEmail;?>" value="<?php echo $userContactEmail;?>" required>
          </div>

          <div class="details-input-group">
            <b class="details-p">Instagram（用戶網址）</b>
            <input class="details-input" id="userIG" type="url" name="userIG" placeholder="<?php echo $userIG;?>" value="<?php echo $userIG;?>" required>
          </div>

          <div class="details-input-group">
            <b class="details-p">Facebook（用戶網址）</b>
            <input class="details-input" id="userFB" type="url" name="userFB" placeholder="<?php echo $userFB;?>" value="<?php echo $userFB;?>" required>
          </div>

          <div class="details-input-group group-ckeditor">
            <b class="details-p">商鋪簡介</b>
            <textarea id="content" class="ckeditor" name="goodsContent" rows="8" cols="50" required></textarea>
          </div>

          <button class="submit-details" id="submit-data" type="submit" name="submit-data">提交</button>
        </form>
      </div>

      <div class="cointainer-pwd-edit">
        <h1 class="change-pwd-heading">更改密碼</h1>

        <form id="updatePwd" class="pwd-form" action="profile-edit-pwd.inc.php" method="post">
          <div class="pwd-group">
            <p class="pwd-p">現在的密碼</p><input class="pwd-input" id="oldPwd" type="password" name="oldPwd" placeholder="現在的密碼" required>
          </div>

          <div class="pwd-group">
            <p class="pwd-p">新密碼</p><input class="pwd-input" id="NewPwd" type="password" name="NewPwd" placeholder="新密碼" required>
            <br>
            <span id="jsNewPwd" class="span-pwd">密碼長度必須多於或等於8個字符,至少需要一個大楷英文字母及一個小楷英文字母，以及需要一個特別字符 @$!%*?&</span>
          </div>

          <div class="pwd-group">
            <p class="pwd-p">重複新密碼</p><input class="pwd-input" id="ConfirmPwd" type="password" name="ConfirmPwd" placeholder="重複新密碼" required>
            <br>
            <span id="jsConfirmPwd" class="span-pwd">密碼不一致</span>
          </div>

          <button class="submit-password" id="submit-password" type="submit" name="submit-password">更改密碼</button>
        </form>
      </div>
   </div>

   <script>
function myFunction() {
  alert("已更改用戶照片，請清除瀏覽器的緩存（cache）以顯示最新照片，或有可能要一段時間才能顯示");
}
</script>

  </body>
</html>
<?php
  require '../../INCLUDES/footer.php';
 ?>
