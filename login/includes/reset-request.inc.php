<?php

if (isset($_POST['reset-request-submit'])) {

  $selecter = bin2hex(random_bytes(8));
  $token = bin2hex(random_bytes(8));

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);



  $url = "https://www.gaakzei.com/login/create-new-password?selector=".$selecter."&validator=".bin2hex($token);//set it later!!!!!!!!!!!!!!!!!!!!!!

  $expires = date("U") + 1800;

  require '../../INCLUDES/dbh.inc.php';

  $userEmail = $_POST["email"];

  $sql = "DELETE FROM pwdreset WHERE pwdResetEmail=?;";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "技術錯誤，請聯絡客服部門 gaakzei@gmail.com 或 請再試一次 //ERROR CODE resetR001";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $userEmail);
    mysqli_stmt_execute($stmt);
  }

  $sql = "INSERT INTO pwdreset (pwdResetEmail, pwdResetSelector, pwdResetToken,pwdResetExpires) VALUES (?,?,?,?);";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "技術錯誤，請聯絡客服部門 gaakzei@gmail.com 或 請再試一次 //ERROR CODE resetR002";
    exit();
    
  } else {
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selecter, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
  }

    mysqli_stmt_close($stmt);


    $to = $userEmail;
    $subject = "GaakZei-重設密碼";

    $message = '
        <!DOCTYPE html>
        <html>
        <head>

          <meta charset="utf-8">
          <meta http-equiv="x-ua-compatible" content="ie=edge">
          <title>Password Reset</title>
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
          /**
           * Avoid browser level font resizing.
           * 1. Windows Mobile
           * 2. iOS / OSX
           */
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
                      <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">重設密碼<br />Reset Password</h1>
                    </td>
                  </tr>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
              </td>
            </tr>
            <!-- end hero -->

            <!-- start copy block -->
            <tr>
              <td align="center" bgcolor="#ffffff">
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                <tr>
                <td align="center" valign="top" width="600">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                  <!-- start copy -->
                  <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                      <p style="margin: 0;">請點按下面的按鈕以重置您的客戶帳戶密碼。如果你沒有提出密碼重設請求，你可以刪除此電子郵件。<br />
                      Tap the button below to reset your customer account password. If you did not request a new password, you can safely delete this email.</p>
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
                                  <a href="'.$url.'" target="_blank" style="display: inline-block; padding: 16px 36px; font-size: 20px; color: #ffffff; text-decoration: none; border-radius: 6px;">重設密碼<br />Reset Password</a>
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
                      <p style="margin: 0;"><a href="'.$url.'" target="_blank">'.$url.'</a></p>
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
        </html>';

    $headers = "From: GaakZei-Customer Service <customer-service@gaakzei.com> \r\n";
    $headers .= "Reply-To: customer-service@gaakzei.com \r\n";
    $headers .= "Content-type:text/html\r\n";

    if (mail($to, $subject, $message, $headers)) {
      header("Location: ../reset-password?reset=success");

    } else {
      header("Location: ../reset-password?reset=fail");
    }

    print_r(error_get_last());
    

}else {
  header("Location: https://www.gaakzei.com/INCLUDES/login");
}
