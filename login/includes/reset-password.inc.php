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
  return password_hash($arr2pwd, PASSWORD_DEFAULT);
}



if (isset($_POST["reset-password-submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];

    $pattern[] = '/[a-z]+/';
    $pattern[] = '/[A-Z]+/';
    $pattern[] = '/[0-9]+/';
    $pattern[] = '/[`~!@#$%^&\*()\ \_\+\-=\{\}\|\\\:";\'<>\?,\.]+/';

    $RegExp = array_pop($pattern);


    if (empty($password) || empty($passwordRepeat)) {
      header("Location: https://www.gaakzei.com/create-new-password?newpwd=empty&selector=".$selector."&validator=".$validator);//Don't forget to edit
      exit();
  }elseif (strlen($password)<8 or strlen($password)>20) {
    header("Location: https://www.gaakzei.com/create-new-password?newpwd=illigalpwd&selector=".$selector."&validator=".$validator);//Don't forget to edit
    exit();
  }elseif (!preg_match($RegExp, $password)) {
    header("Location: https://www.gaakzei.com/create-new-password?newpwd=illigalpwd2&selector=".$selector."&validator=".$validator);//Don't forget to edit
    exit();
  }elseif ($password !== $passwordRepeat) {
      header("Location: https://www.gaakzei.com/create-new-password?newpwd=pwdnotsame&selector=".$selector."&validator=".$validator);
      exit();
    }
    $currentDate = date("U");

    require '../../INCLUDES/dbh.inc.php';

    $sql = "SELECT * FROM pwdreset WHERE pwdResetSelector=? AND pwdResetExpires >=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: https://www.gaakzei.com/login/reset-password?newpwd=expired");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      if (!$row = mysqli_fetch_assoc($result)) {
        header("Location: https://www.gaakzei.com/login/reset-password?newpwd=expired");
        exit();
      } else {

        $tokenBin = hex2bin($validator);


        $tokenCheck = password_verify($tokenBin ,$row["pwdResetToken"]);


        if ($tokenCheck === false) {
          echo "技術錯誤，請再試一次請, 或聯絡客服部門 gaakzei@gmail.com //ERROR CODE resetR005";
          exit();
        } elseif ($tokenCheck === true) {

          $tokenEmail = $row['pwdResetEmail'];

          $sql = "SELECT * FROM users WHERE emailusers =?;";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "技術錯誤，請再試一次請, 或聯絡客服部門 gaakzei@gmail.com //ERROR CODE resetR006";
            exit();
          } else {
            $tokenEmail = $row['pwdResetEmail'];
            mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $num = mysqli_num_rows($result);

            if ($num !== 1) {
              echo "技術錯誤，請再試一次請, 或聯絡客服部門 gaakzei@gmail.com //ERROR CODE resetR007";
              exit();
            } else {

              $sql = "UPDATE users SET pwdUsers=? WHERE emailUsers=?;";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "技術錯誤，請再試一次請, 或聯絡客服部門 gaakzei@gmail.com //ERROR CODE resetR008";
                exit();
              } else {
                $newPwdHash = pwd_hash($password);
                mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
                mysqli_stmt_execute($stmt);

                $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                  echo "技術錯誤，請再試一次請, 或聯絡客服部門 gaakzei@gmail.com //ERROR CODE resetR009";
                  exit();
                } else {
                  mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                  mysqli_stmt_execute($stmt);
                  header("Location: https://www.gaakzei.com?newpwd=pwdupdated");
                }
              }
            }
          }

        }

      }
    }

} else {
  header("Location: https://www.gaakzei.com");
}
