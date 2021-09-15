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
    <title>GaakZei-忘記密碼</title>
    <link rel="stylesheet" href="css/reset-password.css">
    <link rel="shortcut icon" type="image/x-icon" href="GK_icon.GIF"/>
  </head>
  <body>
    <div class="container-contact100">

		<div class="wrap-contact100">
			<form class="contact100-form validate-form" action="includes/reset-request.inc.php" method="post">
				<span class="contact100-form-title">
					忘記密碼
				</span>
        <h4 class="h4">按提交後，請耐心等候5-10秒。</h4>
				<div class="wrap-input100 validate-input">
					<input class="input100" type="email" name="email" placeholder="你的賬號Email" required>
					<span class="focus-input100"></span>
				</div>

				<div class="container-contact100-form-btn">
					<button class="contact100-form-btn" type="submit" name="reset-request-submit">
						<span>
							<i class="fa fa-paper-plane-o m-r-6" aria-hidden="true"></i>
							提交
						</span>
					</button>
				</div>
			</form>
			<?php
         if (isset($_GET["reset"])) {
           if ($_GET["reset"] == "success") {
             echo '<p class="resetsuccess">密碼重設鏈接將會傳送到你的Email郵箱!</p>';//desmond lo 请把这message加入style.css
           }
         }
         if (isset($_GET["newpwd"])) {
           if ($_GET["newpwd"] == "expired") {
             echo '<p class="resetsuccess">操作超時，請重新遞交密碼重設申請</p>';//desmond lo 请把这message加入style.css
           }
         }
          ?>
		</div>
	</div>
  </body>
</html>

<?php
  require "../INCLUDES/footer.php";
  ?>
