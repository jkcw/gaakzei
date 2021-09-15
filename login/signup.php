<?php
  require "../INCLUDES/dbh.inc.php";
  require "../INCLUDES/header.php";
  require '../security/view.inc.php';
  security();
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>GaakZei-注冊</title>
    <link rel="shortcut icon" type="image/x-icon" href="GK_icon.GIF"/>
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="css/signup1112.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="crossorigin="anonymous"></script>
    <script src="js/signup-1127.js"></script>
  </head>

 

  <body>

    <?php
    if (isset($_GET['error'])) {
      if ($_GET['error'] == 'emptyfields') {
        echo '<h2 class="signuperror">請確保已輸入所有表單！</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'invalidmail') {
        echo '<h2 class="signuperror">Email格式不正確</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'invaliduid') {
        echo '<h2 class="signuperror">用戶名只可以使用以下字符a-z/A-Z/0-9/_</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'pwdilligal') {
        echo '<h2 class="signuperror">密碼長度必須為8-20個字符之間</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'pwdilligal2') {
        echo '<h2 class="signuperror">密碼必須包含以下字符 ! @ # $ % * - + (以上其中一項), 數字 以及 大小寫英文</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'passwordcheck') {
        echo '<h2 class="signuperror">密碼不一致!</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'emailtaken') {
        echo '<h2 class="signuperror">Email已被使用</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'invalidid612') {
        echo '<h2 class="signuperror">用戶名範圍必須為6-12個字符之間</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'emailcheck') {
        echo '<h2 class="signuperror">Email不一致!</h2>';//desmond lo 请把这message加入style.css
      }
      elseif ($_GET['error'] == 'sqlerrorver') {
        echo '<h2 class="signuperror">技術錯誤，請聯絡客服部門 gaakzei@gmail.com 或請再試一次</h2>';
      }
      elseif ($_GET['error'] == 'vererror001') {
        echo '<h2 class="signuperror">此Email已經激活 或 技術錯誤，請聯絡客服部門 gaakzei@gmail.com 或請再試一次</h2>';//please edit THX
      }
      elseif ($_GET['error'] == 'sqlerrorver2') {
        echo '<h2 class="signuperror">技術錯誤，請聯絡客服部門 gaakzei@gmail.com 或請再試一次</h2>';
      }
      elseif ($_GET['error'] == 'usrmailerror') {
        echo '用戶名或電郵已被注冊';
      }
  }
     ?>
    <div id="wrapper">
      <div class="form-container">
        <span class="form-heading">注冊</span>
 
        <form class="signup-form" action="includes/signup.inc.php" method="post">

          <div class="input-group">
            <i class="fas fa-user"></i>
            <input class="signup-input" id="usr-name-input" type="text" name="uid" placeholder="用戶名" required>
            <span class="bar"></span>
          </div>

          <div>
            <p class="report" id="usr-name-not-available" style="display:none">用戶名已被注冊</p>
            <p class="report" id="username-not-allow" style="display:none">用戶名只能含有大小楷英文字母，數字及底綫(_)</p>
            <p class="report" id="username-not-allow-len" style="display:none">用戶名長度需為6-15個字符</p>
          </div>
 
          <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input class="signup-input" id="mail-st" type="email" name="mail" placeholder="Email" required>
            <span class="bar"></span>
          </div>
 
          <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input class="signup-input" id="mail-repeat" type="email" name="mail-repeat" placeholder="重複輸入Email" required>
            <span class="bar"></span>
            
          </div>

          <div>
            <p class="report" id="email-not-same" style="display:none">Email不一致</p>
            <p class="report" id="email-not-available" style="display:none">Email已被注冊</p>
          </div>

          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input class="signup-input" id="pwd-st" type="password" name="pwd" placeholder="密碼" required>
            <span class="bar"></span>
          </div>
 
          <div class="input-group">
            <i class="fas fa-lock"></i>
            <input class="signup-input" id="pwd-repeat" type="password" name="pwd-repeat" placeholder="重複輸入密碼" required>
            <span class="bar"></span>
          </div>

          <div>
            <p class="report" id="pwd-not-same" style="display:none">密碼不一致</p>
            <p class="report" id="pwd-not-allow" style="display:none">密碼需多於或等於8個字符，以及小於21個字符</p>
            <p class="report" id="pwd-not-allow-type" style="display:none">密碼需包含數字及英文字符大小楷</p>
          </div>
 
          <input class="input-checkbox" type="checkbox" name="consent" value="consent" id="cbx" style="display: none;" required>
            <label for="cbx" class="check">
              <svg width="19px" height="19px" viewBox="0 0 18 18">
                <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                <polyline points="1 9 7 14 15 4"></polyline>
              </svg>
            </label>
            <div class="word">
              我已詳閱並同意GaakZei的<a href="../consent/term-of-use">服務條款</a>及<a href="../consent/privacy-policy">私隱政策</a>。
            </div>
 
        <div class="input-group">
          <button id="signup-submit" type="submit" name="signup-submit">註冊</button>
        </div>
 
        <div class="switch-login">
          <a href="https://www.gaakzei.com/INCLUDES/login">已有帳號？<span>登入</span></a>
        </div>
 
        </form>
      </div>
    </div>
  </body>
</html>

<?php
  require "../INCLUDES/footer.php";
 ?>
