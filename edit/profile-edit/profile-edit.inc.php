<?php
  session_start();
  require '../../INCLUDES/dbh.inc.php';

  $email = $_SESSION['usersEmail'];

  /* function */
  function upload_data($sql, $conn, $data, $condition) {
    if ($data == '') {

    } else {
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: profile-edit?error=sql");
      } else {
        mysqli_stmt_bind_param($stmt, "ss", $data, $condition);
        mysqli_stmt_execute($stmt);
        if (!mysqli_stmt_close($stmt)) {
          header("Location: profile-edit?error=sql");
          exit();
        }
      }
    }
  }

  function upload_data_is($sql, $conn, $data, $condition) {
    
    if ($data == '') {

    } else {
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: profile-edit?error=sql");
      } else {
        mysqli_stmt_bind_param($stmt, "is", $data, $condition);
        mysqli_stmt_execute($stmt);
        if (!mysqli_stmt_close($stmt)) {
          header("Location: profile-edit?error=sql");
          exit();
      }
    }
  }
}


  if (!isset($_SESSION['usersEmail'])) {
    header("Location: profile-edit?error=nsession");
    exit();
  } elseif (!isset($_POST['submit-data'])) {
    header("Location: profile-edit?error=nsd");
    exit();
  } else {
    $userShopN = $_POST['userShopN'];
    $userPhoneN = $_POST['userPhoneN'];
    $userContactEmail = $_POST['userContactEmail'];
    $userIG = $_POST['userIG'];
    $userFB = $_POST['userFB'];
    $fileContent = $_POST['goodsContent'];

    if (empty($userShopN) && empty($userPhoneN) && empty($userContectEmail) && empty($userIG) && empty($userFB) && empty($fileContent)) {
      header("Location: profile-edit?error=empty");
      exit();

      /*End of checking empty field*/

    } else {
      upload_data("UPDATE users SET userShopN=? WHERE emailUsers=?;", $conn, $userShopN, $email);
      upload_data_is("UPDATE users SET userPhoneN=? WHERE emailUsers=?;", $conn, $userPhoneN, $email);
      upload_data("UPDATE users SET userContactEmail=? WHERE emailUsers=?;", $conn, $userContactEmail, $email);
      upload_data("UPDATE users SET userIG=? WHERE emailUsers=?;", $conn, $userIG, $email);
      upload_data("UPDATE users SET userFB=? WHERE emailUsers=?;", $conn, $userFB, $email);
      upload_data("UPDATE users SET userArticle=? WHERE emailUsers=?;", $conn, $fileContent, $email);
      header("Location: profile-edit?success=success");
      exit();
      }
    }
