<?php
  require "../INCLUDES/header.php";

  //count and redirect

  header('refresh: 10; url=https://www.gaakzei.com/INCLUDES/login');
?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>GaakZei-感謝註冊</title>
    <link rel="shortcut icon" type="image/x-icon" href="GK_icon.GIF"/>
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="css/thankyou1205.css">
  </head>

  <body>
      <div class="main-container">
        <dic class="container-products">
          <div class="thx-container">
          <h1>感謝註冊，請前往電郵激活賬戶</h>
          </div>
          <div class="thx-icon-container">
            <iframe src="https://giphy.com/embed/3o6ozuHcxTtVWJJn32" width="280" height="380" frameBorder="0" class="giphy-embed" allowFullScreen>
            </iframe>
          </div>
          <div class="thx-container">
          <a href="https://www.gaakzei.com"><button class="button button4">按此回到主頁面</button></a>
          </div>  
        </div>
      </div>
  </body>

</html>

<?php
  require "../INCLUDES/footer.php";
?>