<?php
session_start();
require '../INCLUDES/header.php';

/* Isset the get message */
if(isset($_GET['request'])) {

    if ($_GET['request'] == "success") {
        $sys_message = '<h3 style="text-align: center;">已成功發送請求，請檢查您的email郵箱。</h3>';
    }

} else {
    $sys_message = '';
}

?>

<html lang="zh" dir="ltr">
	<head>
        <title>客服部門</title>
        <script src="js/serv.js"></script>
	</head>
    <link rel="stylesheet" href="css/cus-service1029.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<body>

<div style="text-align:center;">
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

<div class="img">
    <div class="">

        <?php echo $sys_message; ?>

        <div class="main-container">
        
			<div class="container-products" id="container">
				<div class="inner">
                    <div class="DocxConversion" style="width: 90%; margin: auto;">

                        <h2 style="text-align: center;">Gaakzei 客服部門</h2>

                        <div id="button_container">
                            <a class="button-a" href="rating-report">
                                <img src="button/csp11.png" width="200" height="200" alt="csp1">
                            </a>

                            <a class="button-a" href="user-report">
                                <img src="button/csp22.png" width="200" height="200" alt="csp2">
                            </a>
                        
                            <button id="show" class="unstyled-button">
                                <img src="button/csp33.png" width="200" height="200" alt="csp3">
                            </button>
                        </div>

                            <div id="myDIV" class="myDIV">

                                <form action="include/customer-service.inc.php" method="post">
                                
                                    <label for="fname">主題</label>
                                        <input class="input-box" type="text" id="主題" name="title-cs" placeholder="請在此輸入" required>

                                    <label for="類別">類別</label>
                                         <input class="input-box" type="text" id="類別" name="category-cs" placeholder="請在此輸入" required>
                                    </select>

                                    <label for="Email">Email</label>
                                        <input class="input-box" type="text" id="Email" name="email-cs" placeholder="請在此輸入" required>

                                    <label for="細節"">細節</label>
                                        <textarea class="input-box" id="細節" name="details-cs" placeholder="請描述細節" style="height:200px" required></textarea>

                                    <label for="名稱">名稱</label>
                                        <input class="input-box" type="text" id="name" name="name-cs" placeholder="請在此輸入" required>

                                    <button class="form-submit" type="submit">提交</button>

                                    <h3 style="text-align: center;">按提交後，請耐心等候5-10秒。</h3>

                                </form>

                                <div align="center">
                                    <button class="button_cont" id="hide">返回</button>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align:center;">
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

</body>
</html>
<?php
require '../INCLUDES/footer.php';
?>