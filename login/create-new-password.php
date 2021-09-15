<?php
  session_start();
  require "../INCLUDES/header.php";
  require '../security/view.inc.php';
  security();
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>GaakZei-重設密碼</title>
    
     <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    
     <link rel="stylesheet" type="text/css" href="css/util.css">
     <link rel="stylesheet" type="text/css" href="css/create_new_pwd.css">
     <link rel="shortcut icon" type="image/x-icon" href="GK_icon.GIF"/>
    
  </head>
  <body>
    <div class="wrapper-main">
         <?php
           $selector = $_GET["selector"];
           $validator = $_GET["validator"];

           if (empty($selector) || empty($validator)) {
             echo "技術錯誤，請再試一次, 或請聯絡客服部門 gaakzei@gmail.com";
           } else {
             if (ctype_xdigit($selector) !== false || ctype_xdigit($validator) !== false) {
               ?>

          <div class="limiter">
            <div class="container-login100">
              <div class="wrap-login100 p-t-50 p-b-90">
               <form class="login100-form validate-form flex-sb flex-w" action="includes/reset-password.inc.php" method="post">
                 <span class="login100-form-title p-b-51">
       						重設密碼
       					 </span>

                 <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                 <input type="hidden" name="validator" value="<?php echo $validator; ?>">

                 <div class="wrap-input100 validate-input m-b-16">
                   <input class="input100" type="password" name="pwd" placeholder="新的密碼" required>
                   <span class="focus-input100"></span>
     					   </div>

                 <div class="wrap-input100 validate-input m-b-16">
                   <input class="input100" type="password" name="pwd-repeat" placeholder="請再次輸入新的密碼" required>
                   <span class="focus-input100"></span>
                 </div>

                 <div class="container-login100-form-btn m-t-17">
                   <button class="login100-form-btn" type="submit" name="reset-password-submit">重設密碼</button>
                 </div>

               </form>
               <?php
             }
           }
           if (isset($_GET['newpwd'])) {
             if ($_GET["newpwd"] == "empty") {
               echo '<p class="resetpwd-error">請確保已輸入所有表單！</p>'; 
             }elseif ($_GET["newpwd"] == "illigalpwd") {
               echo '<p class="resetpwd-error">密碼長度必須為8-20個字符之間</p>'; 
             }elseif ($_GET["newpwd"] == "illigalpwd2") {
               echo '<p class="resetpwd-error">密碼必須包含以下字符 ! @ # $ % * - + (以上其中一項), 數字 以及 大小寫英文</p>'; 
             }elseif ($_GET["newpwd"] == "pwdnotsame") {
               echo '<p class="resetpwd-error">密碼不一致!</p>'; 
             }
           }
          ?>
    </div>
  </body>
</html>

<?php
  require "../INCLUDES/footer.php";
