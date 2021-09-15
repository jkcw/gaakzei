<?php 
    session_start();

    require '../../INCLUDES/header.php';
    require '../../INCLUDES/dbh.inc.php';

    /* get the user id */
    if (!$_GET['uid'] || !$_GET['shopname'] || !$_GET['avg'] || !$_GET['total']) {
        header("Location: https://www.gaakzei.com");

    } else {
        $uid = $_GET['uid'];
        $shopN = $_GET['shopname'];
        $avgGet = $_GET['avg'];
        $totalGet = $_GET['total'];
    }

    require 'include/rating.inc.php';
    require 'include/view.inc.php';
    security($conn);

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $shopN; ?>的過往評價</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" 
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" 
                crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/rating-923.js"></script>
        <!--End of js-->
        <link rel="stylesheet" href="css/rating.css">
        <!--End of css-->
    </head>

    <body>

        <div class="title-container">
            <div class="title-sub-container">
                <h2><a class="profile-refer" href="https://www.gaakzei.com/user-info/<?php echo $uid; ?>-profile"><span><?php echo $shopN; ?></span></a>的過往評價</h2>
                <div class="title-rating-container">
                    <p class="avg-score" value="<?php echo $avgGet; ?>">
                        <span class="svg-span"><?php echo svgImg($avgGet); ?></span>
                        <span class="avg-score-span">平均評分：</span>
                        <?php echo $avgGet; ?>%
                        <span class="total-span">(<?php echo $totalGet; ?>)</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="main-container">
            <div class="prev-comment-container-childDIV">
              <?php echo fetchComments($uid, $conn); ?>
            </div>
          <?php echo $comment_output_button; ?>
        </div>
    </body>
    
    
</html>


<?php 
    require '../../INCLUDES/footer.php';
?>