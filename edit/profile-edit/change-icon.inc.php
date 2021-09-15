<?php
    session_start();
    require '../../INCLUDES/dbh.inc.php';

    /*Check empty*/
    $tmpFilePath = $_FILES['icon_file']['tmp_name'];
    $sessionUid = $_SESSION['uid'];

    if (!isset($_POST['icon_file_submit']) || $tmpFilePath == null || !isset($_SESSION['uid']) ) {
      header("location: profile-edit?error=nophoto");
      exit();

/*===================================================================================*/

      /*Start*/
    } else {
      $tmpFilePath = $_FILES['icon_file']['tmp_name'];
      $fileName = $_FILES['icon_file']['name'];
      $fileError = $_FILES['icon_file']['error'];
      $fileSize = $_FILES['icon_file']['size'];

      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));

      $allowed = array('jpg','jpeg','png','pdf');

/*===================================================================================*/

      /*Check img*/
      if (!in_array($fileActualExt, $allowed)) {
        header("location: profile-edit?error=format");
        exit();

      } elseif ($fileError !== 0) {
        header("location: profile-edit?error=uploadError");
        exit();

      } elseif ($tmpFilePath == ""){//FUCK YOU NULL !!!!! Be careful Next TIME!!!
        header("location: profile-edit?error=fileTmpError");
        exit();

/*===================================================================================*/

        /*Start upload the img*/
      } else {

        $old_img = "../../user-info/user-img/$sessionUid"."-"."profile".".jpg";
        $old_img_new_name = "../../user-info/user-img/$sessionUid"."-"."old".".jpg";
        rename($old_img, $old_img_new_name) ;

        $destination_path = "../../user-info/user-img/";
        $newFilePath = $destination_path . basename("$sessionUid"."-"."profile".".jpg");
        
        /*Upload*/
        if(imagejpeg(imagecreatefromjpeg($tmpFilePath), $newFilePath, 50)) {

          /*update database*/
          $sql = "UPDATE users SET usersIcon=? WHERE idusers=?";
          $stmt = mysqli_stmt_init($conn);

          /*prepare*/
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: profile-edit?error=imgUpload");
            exit();

            /*binding*/
          } else {
            $value = 1;
            mysqli_stmt_bind_param($stmt, "ii", $value, $sessionUid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("location: profile-edit?success=img");
            exit();
          }

          /*if fail*/
      } else {
        header("location: profile-edit?error=imgUpload");
        exit();
      }
    }
  }
