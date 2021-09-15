<?php
  session_start();

  require '../../INCLUDES/dbh.inc.php';

  if (!isset($_SESSION['usersEmail'])) {
    header("Location: https://www.gaakzei.com/INCLUDES/login");
    exit();
  } elseif (!isset($_POST['button-data'])) {
    header("Location: https://www.gaakzei.com?error=nsubmit");
    exit();
  } elseif (!isset($_POST['pid']) || !isset($_POST['uid'])) {
    header("Location: https://www.gaakzei.com?error=npid");
    exit();
  } else {
    $pid = $_POST['pid'];
    $uid = $_POST['uid'];

/*=========================================================================================================*/
    /*delete the old file*/
    $delete_value = $_POST['delete-check'];
    $delete_array = explode('-', $delete_value);

    for ($i=1; $i < 6; $i++) {

      if (in_array($i, $delete_array)) {
        $main_path = "../../products-info/products-img/";
        $old_path = $pid.'-'.$uid.'-'.$i.'.jpg';
        $new_path = 'WFD'.$pid.'-'.$uid.'-'.$i.'.jpg';
        rename($main_path.$old_path, $main_path.$new_path);
      }
    }

/*=========================================================================================================*/
    require 'product-edit-function.inc.php';

/*=========================================================================================================*/
    $email = $_SESSION['usersEmail'];

    $Title = $_POST['goodsTitle'];
    $Content = $_POST['goodsContent'];
    $Address = $_POST['goodsAddress'];
    $Phone = $_POST['goodsPhone'];
    $Price = $_POST['goodsPrice'];
    $Weight = $_POST['goodsWeightG'];
    $Color = $_POST['goodsColor'];
    $Quantity = $_POST['goodsQuantity'];
    $district = $_POST['district'];


    upload_data_s("UPDATE goodsinfo SET goodsTitle=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Title);
    upload_data_s("UPDATE goodsinfo SET goodsAddress=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Address);
    upload_data_d("UPDATE goodsinfo SET goodsPrice=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Price);
    upload_data_d("UPDATE goodsinfo SET goodsWeightG=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Weight);
    upload_data_s("UPDATE goodsinfo SET goodsColor=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Color);
    upload_data_i("UPDATE goodsinfo SET goodsQuantity=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Quantity);
    upload_data_i("UPDATE goodsinfo SET goodsPhone=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Phone);
    upload_data_s("UPDATE goodsinfo SET goodsDistrict=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $district);
    upload_data_s("UPDATE goodsinfo SET goodsContent=? WHERE goodsID=? AND goodsUserID=? ;", $conn, $pid, $uid, $Content);
    $path = $uid.'-'.$pid;
    header("Location: https://www.gaakzei.com/products-info/products-file/$path?success=data");
    exit();
  }