<?php
session_start();
require '../INCLUDES/header.php';

if (isset($_GET['pid']) && isset($_GET['uid'])) {
    $pid = $_GET['pid'];
    $uid = $_GET['uid'];
} else {
    $pid = '';
    $uid = '';
}
?>

<html lang="zh" dir="ltr">
	<head>
        <title>用戶檢舉</title>
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
                                <form action="include/rating-report.inc.php" method="post">

                                    <h2 style="text-align: center;">Gaakzei 評價檢舉</h2>

                                        <div class="outer-container">

                                            <label for="fname">產品編號</label>
                                                <input type="number" value="<?php echo $pid; ?>" id="Pro-ID" name="productID-report" placeholder="請在此輸入" required>

                                            <label for="com-ID">評論者ID</label>
                                                <input type="number" value="<?php echo $uid; ?>" id="com-ID" name="reviewerID-report" placeholder="請在此輸入" required>
                            
                                            <label for="title">標題</label>
                                                <input type="text" id="title" name="title-report" placeholder="請在此輸入" required>

                                            <label for="reason">原因</label>
                                                <textarea type="text" id="reason" name="reason-report" placeholder="請在此輸入" style="height:100px" required></textarea>

                                            <label for="content">名稱</label>
                                                <input type="text" id="content" name="name-report" placeholder="請在此輸入" required>

                                            <label for="Email">Email</label>
                                                <input type="email" id="Email" name="email-report" placeholder="請在此輸入" required>

                                        </div>

                                            <button class="form-submit" type="submit" action="">提交</button>

                                    <h3 style="text-align: center;">按提交後，請耐心等候5-10秒。</h3>

                                </form>
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
</body>
</html>
<?php
require '../INCLUDES/footer.php';
?>