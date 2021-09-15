<?php

/* CONFIDENTIAL */
function pwd_hash($pwd_hash) {
  $hash_code = '@!';
  $pwd_arr = str_split($pwd_hash);
  $total_pwd_len = count($pwd_arr);

  for ($i = 0; $i < $total_pwd_len; $i++) {
    
    if ($i == 0) {
      $pwd_arr[$i] = $hash_code.$pwd_arr[$i];

    } else {
      $real_len = $i + 1;
      $validator = $real_len%4;

      if ($validator == 0) {
        $pwd_arr[$i] = $hash_code.$pwd_arr[$i];
      } else {

      }
    }
  }

  $arr2pwd = implode("",$pwd_arr);
  return $arr2pwd;
}


if (isset($_POST['login-submit'])) {

  require '../../INCLUDES/dbh.inc.php';

  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

  if (empty($mailuid) or empty($password)) {
    header("Location: https://www.gaakzei.com/INCLUDES/login?error=emptyfields");
    exit();
  }

  else {

    $sql = "SELECT * FROM users WHERE emailUsers = ? OR uidUsers = ?";//question mark for Prepare statement
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: https://www.gaakzei.com/INCLUDES/login?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if ($row = mysqli_fetch_assoc($result)) {
        $password = pwd_hash($password);
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        if ($pwdCheck == false) {
          header("Location: https://www.gaakzei.com/INCLUDES/login?error=wrongpwd&mailuid=$mailuid");
          exit();
        }
        else {
          $sqlv = "SELECT verified, emailUsers FROM users WHERE verified=? AND (emailUsers=? OR uidUsers = ?);";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sqlv)) {
            header("Location: https://www.gaakzei.com/INCLUDES/login?error=sql");
            exit();
          } else {
            $ver = 1;
            mysqli_stmt_bind_param($stmt, "iss", $ver, $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck !==1) {
              header("Location: https://www.gaakzei.com/INCLUDES/login?error=sqlerrornotverify");
              exit();
            }
          elseif ($pwdCheck == ture) {
          session_start();//very very very very IMPORTANT!!!!!!!!
          $_SESSION['usersEmail'] = $row['emailUsers'];
          $_SESSION['uid'] = $row['idusers'];
          $_SESSION['userName'] = $row['uidUsers'];

          header("Location: https://www.gaakzei.com?success=login");
          exit();
        }
        else {
          header("Location: https://www.gaakzei.com/INCLUDES/login?error=wrongpwd");
          exit();
        }
      }
    }
  }
      else {
        header("Location: https://www.gaakzei.com/INCLUDES/login?error=nouser");
        exit();
      }
    }

  }
}
else {
  header("Location: https://www.gaakzei.com");
  exit();
}
