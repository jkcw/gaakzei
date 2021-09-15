<?php
/*loop the files*/
$total = 0;
$uploaded = 0;
for ($i=0; $i < 6; $i++) {

  /*received*/
  if ($_FILES['img-upload'.$i.'']['error']  == 0) {

    /*file variables*/
    $tmpFilePath = $_FILES['img-upload'.$i.'']['tmp_name'];
    $fileName = $_FILES['img-upload'.$i.'']['name'];
    $fileSize = $_FILES['img-upload'.$i.'']['size'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg','png','pdf');

    if (!in_array($fileActualExt, $allowed)) {
      header("location: product-edit?gid=$pid&error=format");
      exit();

    } elseif ($tmpFilePath == ""){//FUCK YOU NULL !!!!! Be careful Next TIME!!!
      header("location: product-edit?gid=$pid&error=fileTmpError");
      exit();

      //End of checking the images
    } else {
      $destination_path = "../../products-info/products-img/";
      $newFilePath = $destination_path . basename("$pid"."-"."$uid"."-"."$total".".jpg");
      //Upload the file into the temp dir
      if(imagejpeg(imagecreatefromjpeg($tmpFilePath), $newFilePath, 50)) {
        $total++;
        $uploaded++;
        }
    }

/*=========================================================================================================*/
    /*not received*/
  } elseif ($_FILES['img-upload'.$i.'']['error']  !== 0) {
    /*get the origin informations*/
    $origin = $_POST['img-origin'.$i.''];
    $after = $_POST['img-bool'.$i.''];

    if ($i == 0) {
      $total++;

      /*if the origin img remain unchanged*/
    } elseif ($origin == 1 && $after == 0) {
      /*change their name*/
      $path = "../../products-info/products-img/";
      $origin_name = $pid.'-'.$uid.'-'.$i.'.jpg';
      $new_name = $pid.'-'.$uid.'-'.$total.'.jpg';
      rename($path.$origin_name, $path.$new_name);

      $total++;

      /*if the origin photo was deleted*/
    } else {
      /*other*/
    }
  }

} /*end of loop*/

/*=========================================================================================================*/

    /*update the latest img amount*/
    $update_img_sql = "UPDATE goodsinfo SET goodsIMG=? WHERE goodsID=?;";
    $update_img_stmt = mysqli_stmt_init($conn);

    /*prepare*/
    if (!mysqli_stmt_prepare($update_img_stmt, $update_img_sql)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*binding*/
    } else {
      mysqli_stmt_bind_param($update_img_stmt, "ii", $total, $pid);
      mysqli_stmt_execute($update_img_stmt);
      mysqli_stmt_close($update_img_stmt);
    }

/*=========================================================================================================*/

      function upload_data_s($sql, $conn, $pid, $uid, $data) {

        if ($data == null || $data == '') {

        } else {
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: https://www.gaakzei.com?error=sql");
            exit();
        } else {
          mysqli_stmt_bind_param($stmt, "sii", $data, $pid, $uid);
          mysqli_stmt_execute($stmt);
          if (!mysqli_stmt_close($stmt)) {
            header("Location: https://www.gaakzei.com?error=sql");
            exit();
          }
        }
      }
    }

    function upload_data_i($sql, $conn, $pid, $uid, $data) {

      if ($data == null || $data == '') {

      } else {
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();
      } else {
        mysqli_stmt_bind_param($stmt, "iii", $data, $pid, $uid);
        mysqli_stmt_execute($stmt);
        if (!mysqli_stmt_close($stmt)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();
          }
        }
      }
    }

    function upload_data_d($sql, $conn, $pid, $uid, $data) {

      if ($data == null || $data == '') {

      } else {
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();
      } else {
        mysqli_stmt_bind_param($stmt, "dii", $data, $pid, $uid);
        mysqli_stmt_execute($stmt);
        if (!mysqli_stmt_close($stmt)) {
          header("Location: https://www.gaakzei.com?error=sql");
          exit();
          }
        }
      }
    }
/*=========================================================================================================*/