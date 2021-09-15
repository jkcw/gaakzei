<?php

    /*Check click*/
    if (!isset($_POST['search_box']) || !isset($_POST['option']) || !isset($_POST['search_submit'])) {
      header("Location: https://www.gaakzei.com?error=sql");
      exit();

      /*Start check variable*/
    } else {

      $catergory = $_POST['option'];
      $keywords = $_POST['search_box'];

      $keywords_exploded = explode( " ", $keywords);
      $num = count($keywords_exploded);

      /*Only one word*/
      if ($num == 1) {
        header("Location: https://www.gaakzei.com/search/search?ct=$catergory&query=$keywords&page=1");
        exit();

      } elseif ($num > 1) {

        /*Loop*/
        $plus = 0;
        foreach ($keywords_exploded as $key) {
          $plus++;
          if ($plus == 1) {
            $new_kws .= $key;
          } else {
            $new_kws .= '+'.$key;
          }
        }
        /*Finished loop*/
        header("Location: https://www.gaakzei.com/search/search?ct=$catergory&query=$new_kws&page=1");
        exit();
      }
    }
