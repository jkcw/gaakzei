<?php
  if ($_FILES['img0']['name'] != '') {
    $test = explode(".", $_FILES['img0']['name']);
    $extention = ".jpg";
    $name = rand(100,900).'.'.$extention;
    $location = 'svg/'.$name;
    move_uploaded_file($_FILES["img0"]["tmp_name"], $location);
    echo '<img src="'.$location.'" height="120" width="120" class="img-thumbnail" />';
  }
