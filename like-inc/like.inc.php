<?php
     date_default_timezone_set("Asia/Hong_Kong");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

     require '../INCLUDES/dbh.inc.php';

     if ($_POST['email0'] == null || $_POST['goodsID0'] == null) {
       header("Location: https://www.gaakzei.com");
       exit();
     } else {
       $email = $_POST['email0'];
       $goodsID = $_POST['goodsID0'];

       $currentTime = date("Y-m-d H:i:s");

       /*Get the id of the user*/
       $sqlID = "SELECT idusers FROM users WHERE emailUsers=?";
       $stmtID = mysqli_stmt_init($conn);
       if (!mysqli_stmt_prepare($stmtID, $sqlID)) {
         header("Location: https://www.gaakzei.com?error=sql");
         exit();
       } else {
         mysqli_stmt_bind_param($stmtID, "s", $email);
         mysqli_stmt_execute($stmtID);
         $result = mysqli_stmt_get_result($stmtID);
         $id_row = mysqli_fetch_assoc($result);
         $uid = $id_row['idusers'];

         if (!mysqli_stmt_close($stmtID)) {
           header("Location: https://www.gaakzei.com?error=sql");
           exit();
           
         } else {
           /*Insert new row to goodsLike*/
           $sql = "INSERT INTO goodslike (goodsID, userID, userEmail, likeDate) VALUES (?,?,?,?)";
           $stmt = mysqli_stmt_init($conn);

           if (!mysqli_stmt_prepare($stmt, $sql)) {
             header("Location: https://www.gaakzei.com?error=sql");
             exit();

           } else {
             mysqli_stmt_bind_param($stmt, "iiss", $goodsID, $uid, $email, $currentTime);
             mysqli_stmt_execute($stmt);
             mysqli_stmt_close($stmt);
           }
         }
       }
     }
