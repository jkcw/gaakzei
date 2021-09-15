<?php
    date_default_timezone_set("Asia/Hong_Kong");
    // user_comment.inc.php
    require '../../../INCLUDES/dbh.inc.php';

    if (!isset($_POST['comment-submit'])) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();
    } elseif (!isset($_POST['score'])) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

/*---------------------------------------------------------------------------------------------------------------*/

    } else {
      /*Get the score*/
      if ($_POST['score'] == null) {
        $score = 80;
      } else {
        $score = $_POST['score'];
      }

      /*Get the other information*/
      $text = $_POST['comment-text'];
      $goodsID = $_POST['goodsID'];
      $uid = $_POST['uid'];
      $date = date("Y-m-d H:i:s");

      $ownerID = $_POST['o-uid'];
      $error_path = $ownerID.'-'.$goodsID.'.php';

/*---------------------------------------------------------------------------------------------------------------*/

        /*Check words*/
      if (strlen($text) < 25 || strlen($text) > 200) {
        header("Location: ../$error_path?error=words");
        exit();
        /*Check the img*/
      } else {

/*---------------------------------------------------------------------------------------------------------*/
/*=========================================================================================================*/

    /*loop the files*/
    $total = 0;
    for ($i=0; $i < 3; $i++) {

      /*received*/
      if ($_FILES['fileToUpload'.$i.'']['error']  == 0) {

        /*file variables*/
        $tmpFilePath = $_FILES['fileToUpload'.$i.'']['tmp_name'];
        $fileName = $_FILES['fileToUpload'.$i.'']['name'];
        $fileSize = $_FILES['fileToUpload'.$i.'']['size'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg','jpeg','png','pdf');

        if (!in_array($fileActualExt, $allowed)) {
          header("location: ../$error_path?error=format");
          exit();

        } elseif ($tmpFilePath == ""){//FUCK YOU NULL !!!!! Be careful Next TIME!!!
          header("location: ../$error_path?error=fileTmpError");
          exit();

          //End of checking the images

          //upload img
        } else {

          $destination_path = "../comment-img/";
          $newFilePath = $destination_path . basename("comment-"."$goodsID"."-"."$uid"."-"."$total".".jpg");

          if(imagejpeg(imagecreatefromjpeg($tmpFilePath), $newFilePath, 50)) {
            $total++;
            }

        }

/*=========================================================================================================*/
        /*not received*/
      } elseif ($_FILES['fileToUpload'.$i.'']['error']  !== 0) {

      }

    } /*end of loop*/

/*=========================================================================================================*/

/*---------------------------------------------------------------------------------------------------------*/

    $sql = "INSERT INTO comment (ownerID, CgoodsID, CuserID, UserComment, Cscore, Cimg, Cdate)
            VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);

    /*Check*/
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../$error_path?error=sql");
      exit();

      /*Binding and excution*/
    } else {
      mysqli_stmt_bind_param($stmt, "iiisiis", $ownerID, $goodsID, $uid, $text, $score, $total, $date);
      mysqli_stmt_execute($stmt);

      /*Close the statememnt*/
      if (!mysqli_stmt_close($stmt)) {
        header("Location: ../$error_path?error=sql");
        exit();

/*---------------------------------------------------------------------------------------------------------------*/

        /*Get the comment id*/
      } else {
                header("Location: ../$error_path?success=upload");
                exit();
              }
            }
          }
        }
