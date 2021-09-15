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
      header("location: https://www.gaakzei.com/goods-upload?error=format");
      exit();

    } elseif ($tmpFilePath == "") {
      header("location: https://www.gaakzei.com/goods-upload?error=fileTmpError");
      exit();

      //End of checking the images

      //upload img
    } else {

      $destination_path = "../../products-info/products-img/";
      $newFilePath = $destination_path . basename("$goodsID"."-"."$id"."-"."$total".".jpg");

      if(imagejpeg(imagecreatefromjpeg($tmpFilePath), $newFilePath, 50)) {
        $total++;
        }

    }

/*=========================================================================================================*/
    /*not received*/
  } elseif ($_FILES['img-upload'.$i.'']['error']  !== 0) {

  }

} /*end of loop*/

/*=========================================================================================================*/

  /*upload the number of img*/
  $update_img_sql = "UPDATE goodsinfo SET goodsIMG=? WHERE goodsID=?;";
  $update_img_stmt = mysqli_stmt_init($conn);

  /*prepare*/
  if (!mysqli_stmt_prepare($update_img_stmt, $update_img_sql)) {
    header("Location: https://www.gaakzei.com?error=sql");
    exit();

    /*binding*/
  } else {
    mysqli_stmt_bind_param($update_img_stmt, "ii", $total, $goodsID);
    mysqli_stmt_execute($update_img_stmt);
    mysqli_stmt_close($update_img_stmt);
  }

/*=========================================================================================================*/
