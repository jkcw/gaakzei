<?php
    session_start();
    require 'view.inc.php';
    security();

    require '../../INCLUDES/dbh.inc.php';

    /*Check session*/
    if (!isset($_SESSION['usersEmail']) || !isset($_SESSION['uid'])) {
      header("Location: https://www.gaakzei.com/INCLUDES/login?error=nologin");
      exit();
    } else {
      $userMail = $_SESSION['usersEmail'];
      $uid = $_SESSION['uid'];
    }

    require '../../INCLUDES/header.php';
?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>已讚好</title>
  </head>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="js/my-like917.js"></script>
  <!--End of js-->
  <link rel="stylesheet" href="css/css-like1029.css">

  <body>
    <p id="email_ajax" value="<?php echo $userMail; ?>"></p>
    <p id="uid_ajax" value="<?php echo $uid; ?>"></p>

    <div class="main-container">
      <div class="container-products" id="container">

        <h3 class="title">已讚好的商品</h3>

        <ul class="latest-product-ul" id="pagination_data"></ul>
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
