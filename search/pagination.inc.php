<?php

      $pagination = '';
      $remain_page = $total_pages-$page;

      $query_path = implode("+", $search_exploded);

      $path = "https://www.gaakzei.com/search/search.php?ct=$category&query=$query_path&page=";
      
        if ($total_pages == 1) {
          $pagination = '';
                         /*$pagination = '<div style="text-align:center; width: 100%;">
                          <p class="only-one-page">--結果只有一頁--</p>
                         </div>';*/

/*---------------------------------------------------------------------------------------------------------------*/

          /*only 2 pages*/
        } elseif ($total_pages > 1 && $total_pages <= 2) {
          if ($page == 1) {
            $pagination = '<div class="pagination">
                            <li id="disabled"><a href="">«</a></li>
                            <li class="active"><a href="">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'2">»</a></li>
                            </div>';
          } else {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'1">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li id="disabled"><a href="#">»</a></li>
                            </div>';

          }

/*---------------------------------------------------------------------------------------------------------------*/

          /*only 3 pages*/
        } elseif ($total_pages > 1 && $total_pages <= 3) {
          if ($page == 1) {
            $pagination = '<div class="pagination">
                            <li id="disabled"><a href="#">«</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'2">»</a></li>
                            </div>';
          } elseif ($page == 2) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'1">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'3">»</a></li>
                            </div>';
          } elseif ($page == 3) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'2">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li class="active"><a href="#">3</a></li>
                            <li id="disabled"><a href="#">»</a></li>
                            </div>';
          }

/*---------------------------------------------------------------------------------------------------------------*/

          /*Only 4 pages*/
        } elseif ($total_pages > 1 && $total_pages <= 4) {
          if ($page == 1) {
            $pagination = '<div class="pagination">
                            <li id="disabled"><a href="#">«</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li><a href="'.$path.'2">»</a></li>
                            </div>';
          } elseif ($page == 2) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'1">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li><a href="'.$path.'3">»</a></li>
                            </div>';
          } elseif ($page == 3) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'2">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li class="active"><a href="#">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li><a href="'.$path.'4">»</a></li>
                            </div>';
          } elseif ($page == 4) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'3">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li class="active"><a href="#">4</a></li>
                            <li id="disabled"><a href="#">»</a></li>
                            </div>';
          }

/*---------------------------------------------------------------------------------------------------------------*/

          /*Only 5 Pages*/
        } elseif ($total_pages > 1 && $total_pages <= 5) {
          if ($page == 1) {
            $pagination = '<div class="pagination">
                            <li id="disabled"><a href="#">«</a></li>
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li><a href="'.$path.'5">5</a></li>
                            <li><a href="'.$path.'2">»</a></li>
                            </div>';
          } elseif ($page == 2) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'1">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li><a href="'.$path.'5">5</a></li>
                            <li><a href="'.$path.'3">»</a></li>
                            </div>';
          } elseif ($page == 3) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'2">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li class="active"><a href="#">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li><a href="'.$path.'5">5</a></li>
                            <li><a href="'.$path.'4">»</a></li>
                            </div>';
          } elseif ($page == 4) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'3">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li class="active"><a href="#">4</a></li>
                            <li><a href="'.$path.'5">5</a></li>
                            <li><a href="'.$path.'5">»</a></li>
                            </div>';
          } elseif ($page == 5) {
            $pagination = '<div class="pagination">
                            <li><a href="'.$path.'4">«</a></li>
                            <li><a href="'.$path.'1">1</a></li>
                            <li><a href="'.$path.'2">2</a></li>
                            <li><a href="'.$path.'3">3</a></li>
                            <li><a href="'.$path.'4">4</a></li>
                            <li class="active"><a href="#">5</a></li>
                            <li id="disabled"><a href="#">»</a></li>
                            </div>';
          }

/*---------------------------------------------------------------------------------------------------------------*/


          } elseif ($total_pages > 5) {
            if ($page == 1) {
              $pagination = '<div class="pagination">
                              <li id="disabled"><a href="#">«</a></li>
                              <li class="active"><a href="#">1</a></li>
                              <li><a href="'.$path.'2">2</a></li>
                              <li><a href="'.$path.'3">3</a></li>
                              <li><a href="'.$path.'4">4</a></li>
                              <li><a href="'.$path.'5">5</a></li>
                              <li><a href="'.$path.'2">»</a></li>
                              </div>';
            } elseif ($page == 2) {
              $pagination = '<div class="pagination">
                              <li><a href="'.$path.'1">«</a></li>
                              <li><a href="'.$path.'1">1</a></li>
                              <li class="active"><a href="#">2</a></li>
                              <li><a href="'.$path.'3">3</a></li>
                              <li><a href="'.$path.'4">4</a></li>
                              <li><a href="'.$path.'5">5</a></li>
                              <li><a href="'.$path.'3">»</a></li>
                              </div>';
            } elseif ($page == 3) {
              $pagination = '<div class="pagination">
                              <li><a href="'.$path.'2">«</a></li>
                              <li><a href="'.$path.'1">1</a></li>
                              <li><a href="'.$path.'2">2</a></li>
                              <li class="active"><a href="#">3</a></li>
                              <li><a href="'.$path.'4">4</a></li>
                              <li><a href="'.$path.'5">5</a></li>
                              <li><a href="'.$path.'4">»</a></li>
                              </div>';
            } elseif ($page > 3) {
              $page_plus1 = $page + 1;
              $page_plus2 = $page + 2;
              $page_m1 = $page - 1;
              $page_m2 = $page - 2;
              $page_m3 = $page - 3;
              $page_m4 = $page - 4;
              if ($remain_page >= 2) {
                $pagination = '<div class="pagination">
                                <li><a href="'.$path.$page_m1.'">«</a></li>
                                <li><a href="'.$path.$page_m2.'">'.$page_m2.'</a></li>
                                <li><a href="'.$path.$page_m1.'">'.$page_m1.'</a></li>
                                <li class="active"><a href="#">'.$page.'</a></li>
                                <li><a href="'.$path.$page_plus1.'">'.$page_plus1.'</a></li>
                                <li><a href="'.$path.$page_plus2.'">'.$page_plus2.'</a></li>
                                <li><a href="'.$path.$page_plus1.'">»</a></li>
                                </div>';
              } elseif ($remain_page == 1) {
                $pagination = '<div class="pagination">
                                <li><a href="'.$path.$page_m1.'">«</a></li>
                                <li><a href="'.$path.$page_m3.'">'.$page_m3.'</a></li>
                                <li><a href="'.$path.$page_m2.'">'.$page_m2.'</a></li>
                                <li><a href="'.$path.$page_m1.'">'.$page_m1.'</a></li>
                                <li class="active"><a href="#">'.$page.'</a></li>
                                <li><a href="'.$path.$page_plus1.'">'.$page_plus1.'</a></li>
                                <li><a href="'.$path.$page_plus1.'">»</a></li>
                                </div>';
              } elseif ($remain_page == 0) {
                $pagination = '<div class="pagination">
                                <li><a href="'.$path.$page_m1.'">«</a></li>
                                <li><a href="'.$path.$page_m4.'">'.$page_m4.'</a></li>
                                <li><a href="'.$path.$page_m3.'">'.$page_m3.'</a></li>
                                <li><a href="'.$path.$page_m2.'">'.$page_m2.'</a></li>
                                <li><a href="'.$path.$page_m1.'">'.$page_m1.'</a></li>
                                <li class="active"><a href="#">'.$page.'</a></li>
                                <li id="disabled"><a href="#">»</a></li>
                                </div>';
              }
            }
          }
