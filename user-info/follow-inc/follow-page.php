
<?php
    session_start();
    
    require '../../INCLUDES/dbh.inc.php';

    $output = '';
    require 'follow-page.inc.php';

    require '../../INCLUDES/header.php';
    
    include 'security/view.inc.php';
    security();
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
	<link rel="stylesheet" type="text/css" href="css/follow1107.css">
    <meta charset="utf-8">
    <title>追蹤</title>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" 
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" 
            crossorigin="anonymous"></script>
    <script src="js/follow-page.js"></script>
  </head>
  <body>
  <div class="main-container">
	<div class="container-products" id="container">
      <h3 align="center" id='h3'>追蹤中</h3>
      <ul class="latest-product-ul" id="pagination_data">
        <?php
          echo $output;
         ?>
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
 </body>

  <?php
    require '../../INCLUDES/footer.php';
   ?>
</html>
