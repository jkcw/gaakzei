<?php
session_start();
require '../INCLUDES/header.php';

if(isset($_GET['uid'])) {
    $uid = $_GET['uid'];
} else {
    $uid = '';
}
?>

<html lang="zh" dir="ltr">
	<head>
        <title>評價檢舉</title>
	</head>
    <link rel="stylesheet" href="css/rating-rep1029.css">
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

        <div class="main-container">

			<div class="container-products" id="container">

				<div class="inner">
                    
                            <div id="myDIV" class="myDIV">

                                <form action="include/user-report.inc.php" method="post">

                                    <h2 style="text-align: center;">Gaakzei 評價檢舉</h2>

                                        <div class="outer-container">

                                            <label for="report_user-ID">舉報使用者ID</label>
                                                <input type="number" value="<?php echo $uid; ?>" id="report_user-ID" name="userID-report" placeholder="請在此輸入" required>
                            
                                            <label for="report_title">標題</label>
                                                <input type="text" id="report_title" name="title-report" placeholder="請在此輸入" required>

                                            <label for="report_content">原因</label>
                                                <textarea type="text" id="report_content"" name="reason-report" placeholder="請在此輸入" style="height:200px" required></textarea>

                                            <label for="name-report">名稱</label>
                                                <input type="text" id="name-report" name="name-report" placeholder="請在此輸入" required>

                                            <label for="report_email">Email</label>
                                                <input type="email" id="report_email" name="email-report" placeholder="請在此輸入" required>

                                            <button class="form-submit" type="submit" action="">提交</button>

                                            <h3 style="text-align: center;">按提交後，請耐心等候5-10秒。</h3>

                                        </div>
                                        
                                </form>

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
    

</body>
</html>
<?php
require '../INCLUDES/footer.php';
?>