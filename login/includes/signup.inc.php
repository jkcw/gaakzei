<?php

date_default_timezone_set("Asia/Hong_Kong");

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

if (isset($_POST['signup-submit'])) {

  require '../../INCLUDES/dbh.inc.php';
  require 'user-name-check.inc.php';

  $username = $_POST['uid'];//fetch the signup information
  $email = $_POST['mail'];
  $emailRepeat = $_POST['mail-repeat'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  $pattern[] = '/[a-z]+/';
  $pattern[] = '/[A-Z]+/';
  $pattern[] = '/[0-9]+/';
  $pattern[] = '/[`~!@#$%^&\*()\ \_\+\-=\{\}\|\\\:";\'<>\?,\.]+/';

  $RegExp = array_pop($pattern);

  if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
    header("Location: https://www.gaakzei.com/login/signup?error=emptyfields&uid=".$username."&mail=".$email);
    exit();
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: https://www.gaakzei.com/login/signup?error=invalidmailuid");
    exit();
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: https://www.gaakzei.com/login/signup?error=invalidmail&uid=".$username);
    exit();
  } else if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
    header("Location: https://www.gaakzei.com/login/signup?error=invaliduid&email=".$email);
    exit();
  } elseif (strlen($username)<6 or strlen($username)>15) {
    header("Location: https://www.gaakzei.com/login/signup?error=invalidid612&mail=".$email);//Username 6-12 characters
    exit();
  } elseif ($email !== $emailRepeat) {
    header("Location: https://www.gaakzei.com/login/signup?error=emailcheck&uid=".$username);
    exit();
  } elseif (strlen($password)<8 or strlen($password)>20) {
    header("Location: https://www.gaakzei.com/login/signup?error=pwdilligal&uid=".$username."&mail=".$email);
    exit();
  } elseif ($password !== $passwordRepeat) {
    header("Location: https://www.gaakzei.com/login/signup?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  } elseif (check_user_name_available($conn, $username) != 0 || check_email_available($conn, $email) != 0) {
    header("Location: https://www.gaakzei.com/login/signup?error=usrmailerror");
    exit();
  } else {

    $sql = "SELECT emailUsers FROM users WHERE emailUsers=?";
    $stmt = mysqli_stmt_init($conn);//connect to my sql dbh.inc.php, 初始化声明并返回 mysqli_stmt_prepare() 使用的对象
    if (!mysqli_stmt_prepare($stmt, $sql)) {//Prepare an SQL statement for execution, 準備執行的SQL語句
      header("Location: https://www.gaakzei.com/login/signup?error=sqlerror");
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $email);//String= s, Integer= i, Blob=b, Double= d
      mysqli_stmt_execute($stmt);//execute the DataBase
      mysqli_stmt_store_result($stmt);//Transfers a result set from a prepared statement
      $resultCheck = mysqli_stmt_num_rows($stmt);//Check if the $username is equal to the other UserName in the DataBase
      //If yes, return 1 . If not ,return 0.
      if ($resultCheck > 0) {
        header("Location: https://www.gaakzei.com/login/signup?error=emailtaken&mail=".$email);
        exit();
      } else {

          $sql = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, vkey) VALUES (?,?,?,?)";//input the informations into the DataBase
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {//Check if the $sql and $stmt are worked together
            header("Location: https://www.gaakzei.com/login/signup?error=sqlerror");
            exit();
      } else {
        //Generate a hash value
        $hashedPwd = pwd_hash($password);
        
        $vkey = md5($email.$username);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $vkey);//String= s, Integer= i, Blob=b, Double= d
        mysqli_stmt_execute($stmt);//excute the DataBase
        if (!mysqli_stmt_close($stmt)) {
          header("Location: https://www.gaakzei.com/login/signup?error=sqlerror");
          exit();

        } else {

                         $path = 'https://www.gaakzei.com/login/verify?vkey='.$vkey;
                         $to = $email;
                         $subject = "Email驗證";
                         $message = '<!DOCTYPE html>
                         <html>
                         <head>

                           <meta charset="utf-8">
                           <meta http-equiv="x-ua-compatible" content="ie=edge">
                           <title>賬戶激活</title>
                           <meta name="viewport" content="width=device-width, initial-scale=1">
                           <style type="text/css">
                           /**
                            * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
                            */
                           @media screen {
                             @font-face {
                               font-style: normal;
                               font-weight: 400;
                             }
                             @font-face {
                               font-style: normal;
                               font-weight: 700;
                             }
                           }

                           body,
                           table,
                           td,
                           a {
                             -ms-text-size-adjust: 100%; /* 1 */
                             -webkit-text-size-adjust: 100%; /* 2 */
                           }
                           /**
                            * Remove extra space added to tables and cells in Outlook.
                            */
                           table,
                           td {
                             mso-table-rspace: 0pt;
                             mso-table-lspace: 0pt;
                           }
                           /**
                            * Better fluid images in Internet Explorer.
                            */
                           img {
                             -ms-interpolation-mode: bicubic;
                           }
                           /**
                            * Remove blue links for iOS devices.
                            */
                           a[x-apple-data-detectors] {
                             font-family: inherit !important;
                             font-size: inherit !important;
                             font-weight: inherit !important;
                             line-height: inherit !important;
                             color: inherit !important;
                             text-decoration: none !important;
                           }
                           /**
                            * Fix centering issues in Android 4.4.
                            */
                           div[style*="margin: 16px 0;"] {
                             margin: 0 !important;
                           }
                           body {
                             width: 100% !important;
                             height: 100% !important;
                             padding: 0 !important;
                             margin: 0 !important;
                           }
                           /**
                            * Collapse table borders to avoid space between cells.
                            */
                           table {
                             border-collapse: collapse !important;
                           }
                           a {
                             color: #1a82e2;
                           }
                           img {
                             height: auto;
                             line-height: 100%;
                             text-decoration: none;
                             border: 0;
                             outline: none;
                           }
                           </style>

                         </head>
                         <body style="background-color: #ffffff;">

                           <!-- start preheader -->
                           <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
                             A preheader is the short summary text that follows the subject line when an email is viewed in the inbox.
                           </div>
                           <!-- end preheader -->

                           <!-- start body -->
                           <table border="0" cellpadding="0" cellspacing="0" width="100%">

                             <!-- start logo -->
                             <tr>
                               <td align="center" bgcolor="#ffffff">
                                 <!--[if (gte mso 9)|(IE)]>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                 <tr>
                                 <td align="center" valign="top" width="600">
                                 <![endif]-->
                                 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                   <tr>
                                     <td align="center" valign="top" style="padding: 36px 24px;">
                                         <h1>GaakZei</h1>
                                     </td>
                                   </tr>
                                 </table>
                               </td>
                             </tr>
                             <!-- end logo -->

                             <!-- start hero -->
                             <tr>
                               <td align="center" bgcolor="#ffffff">
                                 <!--[if (gte mso 9)|(IE)]>
                                 <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                 <tr>
                                 <td align="center" valign="top" width="600">
                                 <![endif]-->
                                 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                   <tr>
                                     <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0;  Helvetica, Arial, sans-serif; border-top: 3px solid #ffffff;">
                                       <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">賬戶激活<br />Account Activation</h1>
                                     </td>
                                   </tr>
                                 </table>
                               </td>
                             </tr>
                             <!-- end hero -->

                             <!-- start copy block -->
                             <tr>
                               <td align="center" bgcolor="#ffffff">
                                 <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                                   <!-- start copy -->
                                   <tr>
                                     <td align="left" bgcolor="#ffffff" style="padding: 24px; Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                                       <p style="margin: 0;">請點按下面的按鈕以激活你的GaakZei賬戶。如果你沒有提出賬戶注冊請求，你可以刪除此電子郵件。<br />
                                       Tap the button below to activate your GaakZei account. If you did not request a new registration, you can safely delete this email.</p>
                                     </td>
                                   </tr>
                                   <!-- end copy -->

                                   <!-- start button -->
                                   <tr>
                                     <td align="left" bgcolor="#ffffff">
                                       <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                         <tr>
                                           <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                             <table border="0" cellpadding="0" cellspacing="0">
                                               <tr>
                                                 <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                                   <a href="'.$path.'" target="_blank" style="display: inline-block; padding: 16px 36px; font-size: 20px; color: #ffffff; text-decoration: none; border-radius: 6px;">激活賬戶<br />Account Activation</a>
                                                 </td>
                                               </tr>
                                             </table>
                                           </td>
                                         </tr>
                                       </table>
                                     </td>
                                   </tr>
                                   <!-- end button -->

                                   <!-- start copy -->
                                   <tr>
                                     <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family:Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                                       <p style="margin: 0;">如果以上按鈕失效，請復制並粘貼以下鏈接，並在你的瀏覽器上貼上：<br />If that does not work, copy and paste the following link in your browser:</p>
                                       <p style="margin: 0;"><a href="'.$path.'" target="_blank">'.$path.'</a></p>
                                     </td>
                                   </tr>
                                   <!-- end copy -->

                                   <!-- start copy -->
                                   <tr>
                                     <td align="left" bgcolor="#ffffff" style="padding: 24px; font-family:Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                                       <p style="margin: 0;">Cheers,<br> GaakZei Team</p>
                                     </td>
                                   </tr>
                                   <!-- end copy -->

                                 </table>
                               </td>
                             </tr>
                           </table>
                         </body>
                         </html>

                         ';                                                            //Desmond Plz Design the email content HERE.THX
                         $headers = "From: GaakZei-Customer Service <customer-service@gaakzei.com> \r\n";
                         $headers .= "Reply-To: customer-service@gaakzei.com \r\n";
                         $headers .= "Content-type:text/html\r\n";

                         if (!mail($to, $subject, $message, $headers)) {
                           header("Location: https://www.gaakzei.com/login/signup?error=mailerror");
                           exit();
                         } else {
                           header("Location: https://www.gaakzei.com/login/thankyou");
                       }
                   }
                 }
               }
            }

  mysqli_stmt_close($stmt);//Closes a prepared statement
  mysqli_close($conn);
      }
} else {
  header("Location: https://www.gaakzei.com/login/signup");
  exit();
}
