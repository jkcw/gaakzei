<?php

function update_username($conn, $input, $userID) {
  $sql1 = "INSERT INTO usernameRecord (userID, userNameChanged, dateChange) VALUES (?,?,?)";
  $stmt1 = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt1, $sql1)) {
      return "error";

  } else {
      $date = date("Y-m-d H:i:s");
      mysqli_stmt_bind_param($stmt1, "iss", $userID, $input, $date);
      mysqli_stmt_execute($stmt1);
  }
  return true;
}

if (isset($_GET['vkey'])) {
  require '../INCLUDES/dbh.inc.php';

  $vkey = $_GET['vkey'];

  $sql = "SELECT idusers, emailUsers, verified, vkey FROM users WHERE verified = ? and vkey = ? LIMIT 1";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: https://www.gaakzei.com/login/signup?error=sqlerrorver");
    exit();
  }
  else {
    $verified = 0;
    mysqli_stmt_bind_param($stmt, 'is', $verified, $vkey);
    mysqli_stmt_execute($stmt);
    $result_num = mysqli_stmt_get_result($stmt);
    $resultCheck = mysqli_num_rows($result_num);
    if ($resultCheck !==1) {
      header("Location: https://www.gaakzei.com/login/signup?error=vererror001");
      exit();

    } else {
      $sql = "SELECT idusers, uidUsers, emailUsers, verified, vkey FROM users WHERE verified = ? and vkey = ? LIMIT 1";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: https://www.gaakzei.com/login/signup?error=sqlerrorver");
        exit();
    } else {
      mysqli_stmt_bind_param($stmt, 'is', $verified, $vkey);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
      $id = $row['idusers'];
      $usr_name = $row['uidUsers'];
      $email = $row['emailUsers'];

      $sql = "UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_query($conn, $sql)) {
        header("Location: https://www.gaakzei.com/login/signup?error=sqlerrorver2");
        exit();
    }else {
      $uid = '$uid';
      $uEmail = '$uEmail';
      $newID = '$id';
      $inc_content = "<?php
                        session_start();
                        require '../INCLUDES/dbh.inc.php';
                        require '../INCLUDES/header.php';

                        $uid = $id;
                        $uEmail = \"$email\";
                        $newID = $uid;

                        require 'include/profile-permission.inc.php';

                        require 'profile-new-ui.inc.php';
                        require '../INCLUDES/footer.php';
                     ?>";
          $path = $id.'-profile';
          $fp_inc = fopen("../user-info/$path.php", "wb");


            if (!fwrite($fp_inc, $inc_content)) {
              header("Location: signup?error=fwrite");
              exit();
            } elseif (!fclose($fp_inc)) {
              header("Location: signup?error=fclose");
              exit();
            }
            update_username($conn, $usr_name, $id);
      header("Location: https://www.gaakzei.com?success=signupsuccess");
        }
      }
    }
  }
}
