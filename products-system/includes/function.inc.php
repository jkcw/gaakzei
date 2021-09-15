<?php

  function findUserID()
  {
    require '../../INCLUDES/dbh.inc.php';

    $session = $_SESSION['usersEmail'];
    if (!isset($_SESSION['usersEmail'])) {
        echo "SECTION ERROR  請聯絡客服部門 gaakzei@gmail.com 或請再試一次";
        exit();
  } else {
    $sql = "SELECT idusers FROM users WHERE emailUsers='$session'";
    $result = mysqli_query($conn, $sql);
    mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);

      return $row['idusers'];

      mysqli_close($conn);
      }
    }
