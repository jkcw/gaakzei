<?php
  session_start();
  date_default_timezone_set("Asia/Hong_Kong");

  ini_set('error_reporting', -1);
  ini_set('display_errors', 1);

  require '../../INCLUDES/dbh.inc.php';

if (!isset($_SESSION['usersEmail']) || !isset($_SESSION['uid'])){
  header("Location: https://www.gaakzei.com?error=notlogin");
  exit();
} elseif (!isset($_POST['submit'])) {
    header("Location: https://www.gaakzei.com?error=nosubmit");
    exit();
} else {

  require 'function.inc.php';

  $title = $_POST['goodsTitle'];
  $content = $_POST['goodsContent'];
  $address = $_POST['goodsAddress'];
  $price = $_POST['goodsPrice'];
  $weight = $_POST['goodsWeight'];
  $colour = $_POST['goodsColour'];
  $quantity = $_POST['goodsRefillQuantity'];
  $kyw1 = $_POST['keyword1'];
  $kyw2 = $_POST['keyword2'];
  $kyw3 = $_POST['keyword3'];
  $phone = $_POST['phone'];
  $district = $_POST['district'];

  if (empty($title) || empty($content) || empty($address) || empty($price) || empty($weight) || empty($colour) || empty($quantity)) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=empty");
    exit();
  } elseif (empty($kyw1) || empty($kyw2) || empty($kyw3)) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=kywempty");
    exit();
  } else {

/*=========================================================================================================*/

    /*img check*/
    for ($i=0; $i < 6; $i++) {

      if ($_FILES['img-upload'.$i.'']['error']  == 0) {

        /*file variables*/
        $tmpFilePath = $_FILES['img-upload'.$i.'']['tmp_name'];
        $fileName = $_FILES['img-upload'.$i.'']['name'];
        $fileSize = $_FILES['img-upload'.$i.'']['size'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg','jpeg','png','pdf');

        if (!in_array($fileActualExt, $allowed)) {
          header("location: https://www.gaakzei.com/products-system/goods-upload?error=format");
          exit();

        } elseif ($tmpFilePath == ""){//FUCK YOU NULL !!!!! Be careful Next TIME!!!
          header("location: https://www.gaakzei.com/products-system/goods-upload?error=fileTmpError");
          exit();

          //End of checking the images
        }
    }
    /*End of img check*/

/*=========================================================================================================*/

    if (strlen($title)>60) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=title2long");
    exit();
  } elseif (strlen($content)>750) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=content2long&goodsTitle=".$title);
    exit();
  } elseif (strlen($address)>60) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=address2long&goodsTitle=".$title."&goodsContent=".$content);
    exit();
  } elseif ($price <= 0) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=price0");
    exit();
  } elseif ($weight <= 0) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=weight0");
    exit();
  } elseif ($quantity <= 0) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=quantity0");
    exit();
  } elseif (strlen($colour) > 15) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=colour2long");
    exit();
  } elseif (strlen($kyw1) > 18 || strlen($kyw2) > 18 || strlen($kyw3) > 18) {
    header("Location: https://www.gaakzei.com/products-system/goods-upload?error=kyw2long");
    exit();
  }
  else {
    $id = findUserID();
    $date = date("Y-m-d H:i:s");

    $session = $_SESSION['usersEmail'];
    $token = md5($id.$date.$session);

    $sql = "INSERT INTO goodsinfo (goodsUserID, goodsTitle, goodsContent, goodsAddress, goodsPrice, goodsWeightG, goodsColor, goodsUploadDate, goodsQuantity, goodsToken, goodsRefillDate, goodsDistrict, goodsPhone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt_1 = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt_1, $sql)) {
      header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror55");
      exit();
    } else {

      mysqli_stmt_bind_param($stmt_1, "isssddssisssi", $id, $title, $content, $address, $price, $weight, $colour, $date, $quantity, $token, $date, $district, $phone);
      mysqli_stmt_execute($stmt_1);
    }

    if ($close = false) {
      header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror");
      exit();
    } else {
      $sql = "INSERT INTO keywords (gToken) VALUES (?);";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror");
        exit();
      } else {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        $close2 = mysqli_stmt_close($stmt);

      }
      if ($close2 = false) {
        header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror");
        exit();
      } else {
        $sql = "SELECT goodsID FROM goodsinfo WHERE goodsToken='$token'";
        $result = mysqli_query($conn ,$sql);
        mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);

        $goodsID = $row['goodsID'];
/*=========================================================================================================*/

                require 'upload-img.inc.php';

/*=========================================================================================================*/
      if ($close2 = false) {
        header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror");
        exit();
      } else {

        $sql = "UPDATE keywords
                SET userID=?, goodsIDky=?, keyword1=?, keyword2=?, keyword3=?
                WHERE gToken=?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror");
            exit();
        } else {
          mysqli_stmt_bind_param($stmt, "iissss", $id, $goodsID, $kyw1, $kyw2, $kyw3, $token);
          mysqli_stmt_execute($stmt);
          $finalClose = mysqli_stmt_close($stmt);
          mysqli_close($conn);

        } 
        
        if ($finalClose = false) {
          header("Location: https://www.gaakzei.com/products-system/goods-upload?error=sqlerror");//UPLAOD THE PICTURES
          exit();

/*=========================================================================================================*/

        } else {
          $userIDp = '$userIDp';
          $goodsIDp = '$goodsIDp';

          $inc_content = "<?php
                      session_start();
                      require '../../INCLUDES/header.php';

                      $userIDp = $id ;
                      $goodsIDp = $goodsID ;

                      require 'include/user-products.inc.php';

                      require '../../INCLUDES/footer.php';
              ?>";
              $path = $id.'-'.$goodsID;
              $fp_inc = fopen("../../products-info/products-file/$path.php", "wb");

                if (!fwrite($fp_inc, $inc_content)) {
                  header("Location: https://www.gaakzei.com/products-system/goods-upload?error=fwrite");
                  exit();
                } elseif (!fclose($fp_inc)) {
                  header("Location: https://www.gaakzei.com/products-system/goods-upload?error=fclose");
                  exit();
                } else {
                  mysqli_stmt_close($stmt_1);
                  header("Location: https://www.gaakzei.com?success=uploaded");
                  exit();
                  }
                }
              }
            }
          }
        }
      }
    }
  }
