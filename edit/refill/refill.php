<?php
  session_start();
  require '../../INCLUDES/header.php';
  require '../../INCLUDES/dbh.inc.php';
  require '../edit-security/view.inc.php';
  security();
  
  /*Check session*/
  if (!isset($_SESSION['usersEmail'])) {
    header("Location: https://www.gaakzei.com/INCLUDES/login");
    exit();
  } else {
    $email = $_SESSION['usersEmail'];
    $idSQL = "SELECT idusers FROM users WHERE emailUsers=?";
    $stmtID = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmtID, $idSQL)) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();
    } else {
      mysqli_stmt_bind_param($stmtID, "s", $email);
      mysqli_stmt_execute($stmtID);
      $result = mysqli_stmt_get_result($stmtID);
      $uid = mysqli_fetch_assoc($result);
      $id = $uid['idusers'];
      if (!mysqli_stmt_close($stmtID)) {
        header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
        exit();
      } else {
        $sqlP = "SELECT goodsID, goodsTitle, goodsRefillDate, goodsQuantity FROM goodsinfo WHERE goodsUserID=?";
        $stmtp = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmtp, $sqlP)) {
          header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
          exit();
        } else {
          mysqli_stmt_bind_param($stmtp, "i", $id);
          mysqli_stmt_execute($stmtp);
          $resultP = mysqli_stmt_get_result($stmtp);
          $total_p = mysqli_num_rows($result);

          if (!mysqli_stmt_close($stmtp)) {
            header("Location: https://www.gaakzei.com/INCLUDES/header?error=sql");
            exit();
          }
      }
    }
  }
}
 ?>

<!DOCTYPE html>
<html lang="zh" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>補貨系統</title>
    <link rel="stylesheet" href="https://www.gaakzei.com/edit/refill/css/refill-1201a.css">
    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="refill.js" type="text/javascript"></script>
  </head>
  <body>
    <table>
      <caption><h1>極速補貨系統</h></caption>
        <tr>
          <th>商品ID</th>
          <th>商品標題</th>
          <th>最近一次補貨日期</th>
          <th>上一次補貨數量</th>
          <th>補貨</th>
        </tr>

        <?php
            while ($product = mysqli_fetch_array($resultP)) {
              $gid = $product['goodsID'];
              $title = $product['goodsTitle'];
              $refill_date = $product['goodsRefillDate'];
              $quatity = $product['goodsQuantity'];

              echo      '<tr>
                         <td>'.$gid.'</td>
                         <td>'.$title.'</td>
                         <td id="date'.$gid.'">'.$refill_date.'</td>
                         <td id="quantity'.$gid.'">'.$quatity.'</td>
                         <td><div>
                               <form class="" id="update">
                                 <input type="number" min="1" max="1000" class="input'.$gid.'" value="" required>
                                 <input type="hidden" class="'.$gid.'" value="'.$id.'">
                                 <input type="hidden" class="pid" value="'.$gid.'">
                                 <button type="submit" class="update" value="'.$gid.'">補貨</button>
                               </form>
                         </div></td>
                         </tr>';
            }
         ?>
    </table>
  </body>
</html>

<?php
  require '../../INCLUDES/footer.php';
 ?>
