<?php

  /*Error*/
  if (isset($_GET['error'])) {

  }

  /*Success*/
  if (isset($_GET['success'])) {

    if ($_GET['success'] == 'delete') {
      echo '<p class="profile-system-message">已成功刪除商品</p>';
    }
  }

 ?>
