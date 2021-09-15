<?php
  require 'include/dbh.inc.php';

  if (isset($_SESSION['usersEmail'])) {
    $session = $_SESSION['usersEmail'];
    $sql = "SELECT idusers FROM users WHERE emailUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL error";
    } else {
      mysqli_stmt_bind_param($stmt, "s", $session);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $uid = $row['idusers'];
      mysqli_stmt_close($stmt);
    }
  }
 ?>
 <!DOCTYPE html>
 <html lang="zh" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
     <script src="https://www.gaakzei.com/INCLUDES/js/header1127.js"></script>
     <link rel="stylesheet" href="https://www.gaakzei.com/INCLUDES/css/header1214.css"/>
     <link rel="shortcut icon" type="image/GIF" href="https://www.gaakzei.com/system-img/GK_icon.gif"/>
     <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC%7CRighteous&display=swap" rel="stylesheet">
   </head>
       <header>
           <div class="menu-toggle"><img class="header-menu-toggle" src="https://www.gaakzei.com/INCLUDES/svg/menu.svg" /></div>

           <div class="header-logo"><a class="header-logo-a" href="https://www.gaakzei.com">GaakZei</a></div>
           
           <nav id="search">
             <li id="searchli">
               <div id="form-div" class="s003">
                 <form id="form-search" action="https://www.gaakzei.com/search/search-check.inc.php" method="post">
                   <div class="inner-form">
                     <div class="input-field first-wrap">
                       <div class="input-select">
                       
                       <div class="choices" role="listbox" data-type="select-one" tabindex="0" aria-haspopup="true" aria-expanded="false" dir="ltr" aria-activedescendant="choices-option-bn-item-choice-1">
                          <div class="choices__inner">
                           <select data-trigger="" name="option" class="choices__input is-hidden" tabindex="-1" style="display:none;" aria-hidden="true" data-choice="active"><option id="header-option" value="Products" selected="">Products</option></select>
                           <div class="choices__list choices__list--single"><div id="box-value" class="choices__item choices__item--selectable choices__placeholder" data-item="" data-id="1" data-value="Products" aria-selected="true">
                            Products
                          </div>
                         </div>
                       </div>
                       <div id="dropdown_box" class="choices__list choices__list--dropdown" aria-expanded="false" style="display:none;">
                        <div class="choices__list" dir="ltr" role="listbox"><div class="choices__item choices__item--choice choices__item--selectable choices__placeholder is-highlighted" data-select-text="" data-choice="" data-id="1" data-value="Products" data-choice-selectable="" id="choices-option-bn-item-choice-1" role="option" aria-selected="true">
                         Products
                        </div>
                        <div class="choices__item choices__item--choice choices__item--selectable is-highlighted" data-select-text="" data-choice="" data-id="2" data-value="Users" data-choice-selectable="" id="choices-option-bn-item-choice-2" role="option">
                        Shops
                       </div></div></div></div>
                       </div>
                     </div>
                     <div class="input-field second-wrap">
                       <input id="search" type="text" name="search_box" placeholder="Search....." required/>
                     </div>
                     <div class="input-field third-wrap">
                       <button class="btn-search" type="submit" name="search_submit">
                         <svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                           <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                         </svg>
                       </button>
                     </div>
                   </div>
                 </form>
               </div>
             </li>
           </nav>

         <nav class="header-left-nav">
           <ul>


           <?php
             if (isset($_SESSION['usersEmail']) || isset($_SESSION['uid']) || isset($_SESSION['userName'])) {
               echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/user-info/'.$uid.'-profile">'.$_SESSION['userName'].'</a></li>';
               echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/login/includes/logout.inc.php">登出</a></li>';
             } else {
               echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/INCLUDES/login">登入</a></li>';
               echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/login/signup">未有賬號？注冊</a></li>';
             }
            ?>

       <li class="right"><a class="header-a" href="https://www.gaakzei.com/like-inc/like-page/my-like"><img src="https://www.gaakzei.com/INCLUDES/svg/heart.svg"></a></li>
       <li class="right"><a class="header-a" href="https://www.gaakzei.com/user-info/follow-inc/follow-page"><img src="https://www.gaakzei.com/INCLUDES/svg/followers.svg"></a></li>
       <li class="right"><a class="header-a" href="https://www.gaakzei.com/products-system/goods-upload"><img src="https://www.gaakzei.com/INCLUDES/svg/upload.svg">發佈商品</a></li>

           </ul>
         </nav>

      <nav class="mobile-nav" style="display:none;">
        <ul>
        <li><a class="header-a" href="https://www.gaakzei.com">主頁</a></li>

          <?php
            if (isset($_SESSION['usersEmail']) || isset($_SESSION['uid']) || isset($_SESSION['userName'])) {
              echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/user-info/'.$uid.'-profile">'.$_SESSION['userName'].'</a></li>';
              echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/login/includes/logout.inc.php">登出</a></li>';
            } else {
              echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/INCLUDES/login">登入</a></li>';
              echo '<li class="right"><a class="header-a" href="https://www.gaakzei.com/login/signup">未有賬號？注冊</a></li>';
            }
           ?>

          <li class="right"><a class="header-a" href="https://www.gaakzei.com/like-inc/like-page/my-like"><img src="https://www.gaakzei.com/INCLUDES/svg/heart.svg"></a></li>
          <li class="right"><a class="header-a" href="https://www.gaakzei.com/user-info/follow-inc/follow-page"><img src="https://www.gaakzei.com/INCLUDES/svg/followers.svg"></a></li>
          <li class="right"><a class="header-a" href="https://www.gaakzei.com/products-system/goods-upload"><img src="https://www.gaakzei.com/INCLUDES/svg/upload.svg">發佈商品</a></li>

        </ul>
      </nav>

         <script type="text/javascript">

          $(document).ready(function() {

            $('.mobile-nav').hide();
            $(document).on('click', '.menu-toggle', function() {
              $('.mobile-nav').slideToggle();
            });
          });

         </script>

       </header>
</html>
