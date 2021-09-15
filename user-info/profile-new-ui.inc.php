<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	 <meta name="KeyWords" content="gaakzei'格仔'格仔鋪'<?php echo $userName; ?>'<?php echo $userIG; ?>'<?php echo $userFB; ?>">
     <meta name="Description" content="<?php echo $userArticle; ?>">
     <meta name="Author" content="GaakZei">
     <meta name="Creation-Date" content="<?php echo $userDate; ?>">

	<title><?php echo $userShopN; ?></title>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

  <script>
  $(document).ready(function(){
    var id = "<?php echo $id; ?>";
    var page = 1;
    load_data(page,id);

    function load_data(page,id)
    {
         $.ajax({
              url:"include/pagination.inc.php",
              method:"POST",
              data:{page:page, id:id},
              success:function(data){
				   $('#pagination_data').html(data);
              }
         });
    }

    function totalPages(id)
    {
        $.ajax({
            async:false,
            //做成同步
            url:"https://www.gaakzei.com/user-info/include/count-rows.inc.php",
            data: {id:id},
            dataType:"TEXT",
            success:function(data){
              result = data;
              }
            });
            return result;
    }
    $(document).on('click', '.prev', function() {
        var page = $(this).attr("id") ;
        if(page == 0) {
          return false;
        } else {
        load_data(page,id);
        }
    });
    $(document).on('click', '.next', function() {
        var page = $(this).attr("id") ;
        totalPages(id);
        if(page > result) {
          return false;
        } else {
        load_data(page,id);
        }
    });
  });
  </script>

	<script type="text/javascript" src="profile-follow.js"></script>
	<script type="text/javascript" src="profile-like-system-profile-news.js"></script>
	<script type="text/javascript" src="profile-delete-product.js"></script>
	<script type="text/javascript" src="profile-rating.js"></script>
	<link rel="stylesheet" href="css/profile-main1126.css">
	<link rel="shortcut icon" type="image/GIF" href="GK_icon.GIF"/>
</head>


	<?php
		require 'include/check-follow.inc.php';
		require 'include/avg-rating.inc.php';
		require 'system-message.inc.php';
		require '../security/view.inc.php';
	security();
	 ?>

<body>

	<div class="main-container">

		<div class="profile-top">

			<div class= "profile-card">

				<div class="card-header">
					<?php
						if ($userIcon == 1) {
							$icon_output = '<img class="profile-icon" src="user-img/'.$uid.'-profile.jpg"/>';
						} else {
							$icon_output = '<img class="profile-icon" src="system-img/default_icon.png"/>';
						}
						echo $icon_output;
					 ?>

				<a href="https://www.gaakzei.com/customer-service/user-report?uid=<?php echo $uid ?>">
					<img class="report-svg" src="system-img/report.svg" alt="gaakzei profile <?php echo $userName ?>">
				</a>

				</div>

				<div class="card-body">
					
					<h1 class="card-username"><?php echo $userName; ?></h1>
					<p class="card-userID">ID：<?php echo $uid; ?></p>
					<p class="card-userDate"><?php echo $user_join_date; ?></p>
					<?php
						echo $follow_button;
					 ?>
				</div>

				<div class="card-rating-div">

					<div class="rating-icon-div">
						<?php echo $score_icon ?>
					</div>
					
					<a href="https://www.gaakzei.com/user-info/rating/rating?uid=<?php echo $uid; ?>&avg=<?php echo $roundedAvgRating; ?>&total=<?php echo $totalComment; ?>&shopname=<?php echo $userShopN; ?>" style="text-decoration: none;">
						<div class="rating-info-div">
							<div class="rating-info-sub-div">
								<p class="rating-info-p" 
								id="avg-rating"
								value="<?php echo $roundedAvgRating; ?>">
								<?php echo $roundedAvgRating; ?>%</p>
						</div>
					
							<div class="rating-info-sub-div">
								<p class="rating-info-p">Total: <?php echo $totalComment; ?></p>
							</div>
						</div>
					</a>
				</div>

				<div class="card-footer">
					<div class="card-col vr">
						<p class="card-footer-p" id="num_followers" value="<?php echo $num_f; ?>">
							<span class="count" id="new_num_f"><?php echo $num_f; ?></span>
							Followers</p>
							<p id="ownerID" value="<?php echo $uid; ?>"></p>
					</div>
					<div class="card-col">
						<p class="card-footer-p"><span class="count"><?php echo $num_p; ?></span> Products</p>
					</div>
				</div>

			</div>

			<div class="store-details">

				<div class="user-store-info">
					<h1 class="store-name"><?php echo $userShopN; ?></h1>
					<p class="store-phone">查詢電話：<?php echo $userPhoneN; ?></p>
					<p class="store-email"><a href="mailto:<?php echo $userContectEmail; ?>">電郵地址：<?php echo $userContectEmail; ?></a></p>
					<p class="store-ig">Instagram：<?php echo $userIG; ?></p>
					<p class="store-fb"><a href="<?php echo $userFB; ?>">Facebook</a></p>
					<?php
						echo $edit_button;
					 ?>
				</div>

				<div class="user-store-article">
					<p class="details-p-info"><?php echo $userArticle; ?></p>
				</div>

			</div>


		</div>


	<main>

			<div class="container-products" id="container">
				<h3 align="center" id='h3'>Products</h3>
				<ul class="profile-product-ul" id="pagination_data">
				</ul>
    	</div>

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
	</main>

	

</body>
</html>
