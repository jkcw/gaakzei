<?php
  $session = $_SESSION['usersEmail'];
  if (!isset($_SESSION['usersEmail'])) {
    echo "Login please";// Delete later
    exit();
    header("Location: ");//Direct to login.php, edit it later
    exit();
  } else {
    $sql = "SELECT idusers, userShopN, userPhoneN, userContactEmail, userIG, userFB, usersIcon FROM users WHERE emailUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "SQL error";
      exit();
      header("Location: ");//Edit later
      exit();
    } else {
      mysqli_stmt_bind_param($stmt, "s", $session);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);

      $idusers = $row['idusers'];
      $userShopN = $row['userShopN'];
      $userPhoneN = $row['userPhoneN'];
      $userContactEmail = $row['userContactEmail'];
      $userIG = $row['userIG'];
      $userFB = $row['userFB'];
      $usersIcon = $row['usersIcon'];

      mysqli_stmt_close($stmt);
    }
  }

  function icon_status($usersIcon, $idusers) {
    return ($usersIcon == 1) ? '<img id="icon-container" class="profile-icon" src="https://www.gaakzei.com/user-info/user-img/'.$idusers.'-profile.jpg"/>' : '<img id="icon-container" class="profile-icon" src="https://www.gaakzei.com/user-info/system-img/default_icon.png"/>'; 
  }