<?php
  session_start();
  require 'header.php';
  require '../security/view.inc.php';
  if (isset($_SESSION['usersEmail'])) {
	exit(header("https://www.gaakzei.com?error=alreadylogin"));
  }
  security();

 ?>

 <!DOCTYPE html>
 <html lang="zh" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>登入</title>
	 
	 	<link rel="stylesheet" type="text/css" href="css/util.css">
     	<link rel="stylesheet" type="text/css" href="css/login-1124.css">
		<link rel="shortcut icon" type="image/x-icon" href="GK_icon.GIF"/>

     	<script
     	  src="https://code.jquery.com/jquery-3.4.1.min.js"
     	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
     	  crossorigin="anonymous"></script>
   </head>
   <body>

      <div class="limiter">
    		<div class="container-login100">
    			<div class="wrap-login100 p-t-50 p-b-90">

    				<form class="login100-form validate-form flex-sb flex-w" action="https://www.gaakzei.com/login/includes/login.inc.php" method="post">
    					<span class="login100-form-title p-b-51">
    						歡迎登入GaakZei！
    					</span>


    					<div class="wrap-input100 validate-input m-b-16" data-validate = "Email">
    						<input class="input100" type="email" name="mailuid" placeholder="Email" required>
    						<span class="focus-input100"></span>
    					</div>


    					<div class="wrap-input100 validate-input m-b-16" data-validate = "密碼">
    						<input class="input100" type="password" name="pwd" placeholder="密碼" required>
    						<span class="focus-input100"></span>
    					</div>

    					<div class="flex-sb-m w-full p-t-3 p-b-24">
    						<div class="contact100-form-checkbox">
    							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">

    						</div>

    						<div>
    							<a class="login-a" href="https://www.gaakzei.com/login/reset-password" class="txt1">
    								忘記密碼?
    							</a>
                  <a class="login-a" href="https://www.gaakzei.com/login/signup" class="txt1">
    								注冊
    							</a>
    						</div>
    					</div>

    					<div class="container-login100-form-btn m-t-17">
    						<button class="login100-form-btn" type="submit" name="login-submit">
    							登入
    						</button>
    					</div>

    				</form>

              <?php
                if (isset($_GET['error'])) {
                  if ($_GET['error'] == 'emptyfields') {
                  echo '<h4 class="login_error">請確保已輸入所有表單！</h4>';
                } elseif ($_GET['error'] == 'sqlerror') {
                  echo '<h4 class="login_error">技術錯誤，請聯絡客服部門 gaakzei@gmail.com 或請再試一次</h4>';
                } elseif ($_GET['error'] == 'wrongpwd') {
                  echo '<h4 class="login_error">密碼不正確，請重新再試。<br>如忘記密碼，<br>請按一下忘記密碼以進行密碼重設</h4>';
                } elseif ($_GET['error'] == 'sqlerrornotverify') {
                  echo '<h4 class="login_error">不好意思,你的賬戶尚未驗證，請檢查Email郵箱。如遇到問題請聯絡客服部門 gaakzei@gmail.com</h4>';
                } elseif ($_GET['error'] == 'nouser') {
                  echo '<h4 class="login_error">用戶名錯誤，或者你尚未注冊。</h4>';
                } elseif ($_GET['error'] == 'nologin') {
                  echo '<h4 class="login_error">請先登入</h4>';
                }
              }
               ?>
    			</div>
    		</div>
    	</div>

    	<script src="js/login-main.js"></script>

   </body>

   <?php
    require 'footer.php';
    ?>
 </html>
