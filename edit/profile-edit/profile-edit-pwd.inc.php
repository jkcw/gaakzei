<?php
  session_start();
  require '../../INCLUDES/dbh.inc.php';

  $email = $_SESSION['usersEmail'];

  if (!isset($_SESSION['usersEmail'])) {
    header("Location: profile-edits?error=nsession");
    exit();
  } elseif (!isset($_POST['submit-password'])) {
    header("Location: profile-edit?error=nsd");
    exit();
  } else {

    $oldPwd = $_POST['oldPwd'];
    $nPwd = $_POST['NewPwd'];
    $rePwd = $_POST['ConfirmPwd'];

    if (empty($oldPwd) || empty($nPwd) || $nPwd !== $rePwd) {
      header("Location: profile-edit?error=npwd");
      exit();
    } else {
      $pwdCheckSQL = "SELECT pwdUsers FROM users WHERE emailUsers=?;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $pwdCheckSQL)) {
        header("Location: profile-edit?error=sql");
        exit();
      } else {

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $pwd = $row['pwdUsers'];
        $pwdCheck = password_verify($oldPwd, $pwd);
        mysqli_stmt_close($stmt);

        if ($pwdCheck == false) {
          echo "5";
          header("Location: profile-edit?error=pwdWrong");
          exit();

          /*End of checking password*/
      } else {
        $updateSQL = "UPDATE users SET pwdUsers=? WHERE emailUsers=?;";
        $stmtU = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtU, $updateSQL)) {
          header("Location: profile-edit?error=sql");
          exit();
        } else {
          $hashedPwd = password_hash($nPwd, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmtU, "ss", $hashedPwd, $email);
          mysqli_stmt_execute($stmtU);
          if (!mysqli_stmt_close($stmtU)) {
            header("Location: profile-edit?error=sql");
            exit();

          } else {
            header("Location: profile-edit?success=pwd");
            exit();
          }
        }
      }
    }
  }
}
